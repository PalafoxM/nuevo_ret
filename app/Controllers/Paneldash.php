<?php
namespace App\Controllers;

class Paneldash extends BaseController {

    public function index()
    {
        if (! $this->session->get('logged_adm'))
            return redirect()->to('panelauth');

        $data = [
            'main'              =>  'panelret/section/dashboard',
            'name'              =>  ucfirst($this->session->get('name_adm')),
            'email'             =>  $this->session->get('email_adm'),
            'dashboard_cards'   =>  $this->buildSummaryCards(),
            'giro_chart'        =>  $this->groupCount('g_giro', ['visible' => 1, 'giro <>' => 0], 'giro', 6),
            'municipio_chart'   =>  $this->groupCount('municipio_nombre', ['visible' => 1, 'municipio <>' => 0], 'municipio', 6),
            'recent_records'    =>  $this->recentRecords(),
            'daily_series'      =>  $this->dailyRegistrations(7),
        ];

        return view('panelret/template', $data);
    }

    private function buildSummaryCards()
    {
        return [
            [
                'title' => 'Registros activos',
                'value' => $this->countRecords(['giro <>' => 0, 'municipio <>' => 0]),
                'tone'  => 'navy',
                'icon'  => 'fa-building-o',
                'url'   => BASE_URL.'paneladm/todos',
            ],
            [
                'title' => 'Hoy',
                'value' => $this->countRecords(['visible' => 1, 'fecha' => date('Y-m-d')]),
                'tone'  => 'sky',
                'icon'  => 'fa-sun-o',
                'url'   => BASE_URL.'paneladm/hoy',
            ],
            [
                'title' => 'Pendientes',
                'value' => $this->countRecords(['visible' => 1, 'concluido' => 0, 'aprobado' => 0, 'giro <>' => 0, 'municipio <>' => 0]),
                'tone'  => 'red',
                'icon'  => 'fa-clock-o',
                'url'   => BASE_URL.'paneladm/pendientes',
            ],
            [
                'title' => 'Concluidos',
                'value' => $this->countRecords(['visible' => 1, 'concluido' => 1, 'aprobado' => 0, 'giro <>' => 0, 'municipio <>' => 0]),
                'tone'  => 'blue',
                'icon'  => 'fa-flag-checkered',
                'url'   => BASE_URL.'paneladm/concluidos',
            ],
            [
                'title' => 'Aprobados',
                'value' => $this->countRecords(['visible' => 1, 'concluido' => 1, 'aprobado' => 1, 'giro <>' => 0, 'municipio <>' => 0]),
                'tone'  => 'green',
                'icon'  => 'fa-check-circle-o',
                'url'   => BASE_URL.'paneladm/aprobados',
            ],
            [
                'title' => 'Renovaciones',
                'value' => $this->countRecords(['visible' => 1, 'renovar' => 1, 'giro <>' => 0, 'municipio <>' => 0]),
                'tone'  => 'orange',
                'icon'  => 'fa-refresh',
                'url'   => BASE_URL.'paneladm/renovaciones',
            ],
            [
                'title' => 'Vencidos',
                'value' => $this->countRecords(['visible' => 0, 'concluido' => 0, 'aprobado' => 0, 'giro <>' => 0, 'municipio <>' => 0]),
                'tone'  => 'gray',
                'icon'  => 'fa-times-circle-o',
                'url'   => BASE_URL.'paneladm/vencidos',
            ],
        ];
    }

    private function countRecords(array $where = [])
    {
        if (! $this->db)
            return 0;

        return (int) $this->db->table('vw_usr_datos')
            ->where($where)
            ->countAllResults();
    }

    private function groupCount($field, array $where = [], $alias = 'label', $limit = 6)
    {
        if (! $this->db)
            return [];

        $rows = $this->db->table('vw_usr_datos')
            ->select($field.' AS '.$alias.', COUNT(*) AS total', false)
            ->where($where)
            ->groupBy($field)
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();

        if (! $rows)
            return [];

        $max = max(array_map(static fn($row) => (int) $row['total'], $rows));

        return array_map(static function ($row) use ($alias, $max) {
            $total = (int) $row['total'];
            $label = trim((string) ($row[$alias] ?? 'Sin dato'));

            return [
                'label'   => $label !== '' ? $label : 'Sin dato',
                'total'   => $total,
                'percent' => $max > 0 ? max(8, (int) round(($total / $max) * 100)) : 0,
            ];
        }, $rows);
    }

    private function recentRecords($limit = 8)
    {
        if (! $this->db)
            return [];

        return $this->db->table('vw_usr_datos')
            ->select('clave, nombre_comercial, g_giro, municipio_nombre, correo, dg_fecha_registro_alt, visible, concluido, aprobado, renovar')
            ->where(['visible' => 1])
            ->orderBy('dg_fecha_registro', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    private function dailyRegistrations($days = 7)
    {
        if (! $this->db)
            return [];

        $rawRows = $this->db->table('vw_usr_datos')
            ->select("DATE(dg_fecha_registro) AS registro_dia, COUNT(*) AS total", false)
            ->where('dg_fecha_registro >= DATE_SUB(CURDATE(), INTERVAL '.((int) $days - 1).' DAY)', null, false)
            ->where(['visible' => 1])
            ->groupBy('DATE(dg_fecha_registro)')
            ->orderBy('registro_dia', 'ASC')
            ->get()
            ->getResultArray();

        $indexed = [];
        foreach ($rawRows as $row)
            $indexed[$row['registro_dia']] = (int) $row['total'];

        $series = [];
        $max = 0;
        for ($i = $days - 1; $i >= 0; $i--)
        {
            $date = date('Y-m-d', strtotime('-'.$i.' day'));
            $total = $indexed[$date] ?? 0;
            $max = max($max, $total);
            $series[] = [
                'label' => date('d/m', strtotime($date)),
                'total' => $total,
            ];
        }

        return array_map(static function ($point) use ($max) {
            $point['percent'] = $max > 0 ? max(10, (int) round(($point['total'] / $max) * 100)) : 10;
            return $point;
        }, $series);
    }
}
