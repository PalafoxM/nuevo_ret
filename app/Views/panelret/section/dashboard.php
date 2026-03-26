<?php $this->session = \Config\Services::session(); ?>

<style>
  .ret-admin-dashboard {
    padding: 26px 18px 34px;
    background:
      radial-gradient(circle at top right, rgba(21, 101, 192, 0.08), transparent 24%),
      radial-gradient(circle at left center, rgba(255, 138, 0, 0.08), transparent 22%),
      #f4f7fb;
    min-height: calc(100vh - 90px);
  }

  .ret-admin-hero {
    margin-bottom: 24px;
    padding: 28px 30px;
    border-radius: 24px;
    background: linear-gradient(135deg, #0f2e63 0%, #1565c0 55%, #1e88e5 100%);
    color: #fff;
    box-shadow: 0 18px 50px rgba(15, 46, 99, 0.18);
  }

  .ret-admin-hero h1 {
    margin: 0 0 10px;
    font-size: 30px;
    font-weight: 700;
  }

  .ret-admin-hero p {
    margin: 0;
    max-width: 780px;
    color: rgba(255, 255, 255, 0.88);
    line-height: 1.7;
  }

  .ret-admin-grid {
    display: grid;
    grid-template-columns: repeat(12, minmax(0, 1fr));
    gap: 18px;
  }

  .ret-admin-card {
    background: #fff;
    border-radius: 22px;
    padding: 22px;
    box-shadow: 0 14px 35px rgba(28, 44, 64, 0.08);
  }

  .ret-admin-kpi {
    grid-column: span 12;
    display: flex;
    align-items: center;
    gap: 16px;
    min-height: 124px;
    color: #16324f;
  }

  .ret-admin-kpi-icon {
    width: 58px;
    height: 58px;
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #fff;
    flex: 0 0 auto;
  }

  .ret-admin-kpi h3 {
    margin: 0 0 8px;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #5c6d82;
  }

  .ret-admin-kpi strong {
    display: block;
    font-size: 34px;
    line-height: 1;
    color: #10243a;
  }

  .ret-admin-kpi a {
    display: inline-block;
    margin-top: 8px;
    color: #1459b3;
    font-weight: 600;
    text-decoration: none;
  }

  .ret-tone-navy .ret-admin-kpi-icon { background: linear-gradient(135deg, #0f2e63, #1565c0); }
  .ret-tone-sky .ret-admin-kpi-icon { background: linear-gradient(135deg, #00acc1, #29b6f6); }
  .ret-tone-red .ret-admin-kpi-icon { background: linear-gradient(135deg, #c62828, #ef5350); }
  .ret-tone-blue .ret-admin-kpi-icon { background: linear-gradient(135deg, #1565c0, #42a5f5); }
  .ret-tone-green .ret-admin-kpi-icon { background: linear-gradient(135deg, #2e7d32, #66bb6a); }
  .ret-tone-orange .ret-admin-kpi-icon { background: linear-gradient(135deg, #ef6c00, #ffa726); }
  .ret-tone-gray .ret-admin-kpi-icon { background: linear-gradient(135deg, #546e7a, #90a4ae); }

  .ret-admin-panel {
    grid-column: span 12;
  }

  .ret-admin-panel h2 {
    margin: 0 0 6px;
    font-size: 22px;
    color: #132d4f;
  }

  .ret-admin-panel p {
    margin: 0 0 18px;
    color: #66788d;
  }

  .ret-admin-bars {
    display: grid;
    gap: 12px;
  }

  .ret-admin-bar-row {
    display: grid;
    grid-template-columns: minmax(120px, 210px) 1fr 60px;
    gap: 12px;
    align-items: center;
  }

  .ret-admin-bar-label {
    font-weight: 600;
    color: #17385d;
  }

  .ret-admin-bar-track {
    height: 12px;
    border-radius: 999px;
    background: #e8eff7;
    overflow: hidden;
  }

  .ret-admin-bar-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(135deg, #1565c0, #42a5f5);
  }

  .ret-admin-bar-value {
    font-weight: 700;
    color: #0f2e63;
    text-align: right;
  }

  .ret-admin-trend {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 12px;
    align-items: end;
    min-height: 220px;
  }

  .ret-admin-trend-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: end;
    gap: 10px;
    min-height: 200px;
  }

  .ret-admin-trend-bar {
    width: 100%;
    min-height: 16px;
    border-radius: 16px 16px 8px 8px;
    background: linear-gradient(180deg, #ff8a00 0%, #ffb74d 100%);
    box-shadow: inset 0 -6px 12px rgba(255, 255, 255, 0.18);
  }

  .ret-admin-trend-item strong {
    color: #122b48;
    font-size: 18px;
  }

  .ret-admin-trend-item span {
    color: #66788d;
    font-size: 12px;
  }

  .ret-admin-table {
    width: 100%;
    border-collapse: collapse;
  }

  .ret-admin-table th,
  .ret-admin-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #e7eef6;
    vertical-align: top;
  }

  .ret-admin-table th {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7c91;
  }

  .ret-admin-table td {
    color: #18314d;
  }

  .ret-admin-table a {
    color: #1459b3;
    font-weight: 700;
    text-decoration: none;
  }

  .ret-status-pill {
    display: inline-flex;
    align-items: center;
    padding: 7px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
  }

  .ret-status-registrado { background: #eaf4ff; color: #1565c0; }
  .ret-status-renovacion { background: #fff3e0; color: #ef6c00; }
  .ret-status-aprobado { background: #e8f5e9; color: #2e7d32; }
  .ret-status-concluido { background: #e3f2fd; color: #1565c0; }
  .ret-status-pendiente { background: #ffebee; color: #c62828; }
  .ret-status-vencido { background: #eceff1; color: #455a64; }

  .ret-admin-empty {
    color: #6a7b90;
    font-style: italic;
  }

  @media (min-width: 768px) {
    .ret-admin-kpi { grid-column: span 6; }
    .ret-admin-panel-half { grid-column: span 6; }
  }

  @media (min-width: 1200px) {
    .ret-admin-kpi { grid-column: span 3; }
  }

  @media (max-width: 767px) {
    .ret-admin-dashboard {
      padding: 18px 10px 28px;
    }

    .ret-admin-hero {
      padding: 22px 18px;
    }

    .ret-admin-bar-row {
      grid-template-columns: 1fr;
    }

    .ret-admin-trend {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .ret-admin-table {
      display: block;
      overflow-x: auto;
      white-space: nowrap;
    }
  }
</style>

<?php
  $statusClass = static function ($row) {
    if ((int) ($row['visible'] ?? 1) === 0) {
      return ['label' => 'Vencido', 'class' => 'ret-status-vencido'];
    }
    if ((int) ($row['renovar'] ?? 0) === 1) {
      return ['label' => 'Renovacion', 'class' => 'ret-status-renovacion'];
    }
    if ((int) ($row['aprobado'] ?? 0) === 1) {
      return ['label' => 'Aprobado', 'class' => 'ret-status-aprobado'];
    }
    if ((int) ($row['concluido'] ?? 0) === 1) {
      return ['label' => 'Concluido', 'class' => 'ret-status-concluido'];
    }
    return ['label' => 'Pendiente', 'class' => 'ret-status-pendiente'];
  };
?>

<div id="page-wrapper">
  <section class="ret-admin-dashboard">
    <div class="ret-admin-hero">
      <h1>Panel Ejecutivo RET</h1>
      <p>Consulta el comportamiento del registro estatal con indicadores en tiempo real, distribución por giro y municipio, y acceso rápido a los trámites más recientes.</p>
    </div>

    <div class="ret-admin-grid">
      <?php foreach (($dashboard_cards ?? []) as $card): ?>
      <article class="ret-admin-card ret-admin-kpi ret-tone-<?=$card['tone']?>">
        <span class="ret-admin-kpi-icon"><i class="fa <?=$card['icon']?>"></i></span>
        <div>
          <h3><?=$card['title']?></h3>
          <strong><?=number_format((int) $card['value'])?></strong>
          <a href="<?=$card['url']?>">Ver detalle</a>
        </div>
      </article>
      <?php endforeach; ?>

      <article class="ret-admin-card ret-admin-panel ret-admin-panel-half">
        <h2>Registros por Giro</h2>
        <p>Los giros con mayor número de registros visibles en la plataforma.</p>
        <?php if (! empty($giro_chart)): ?>
        <div class="ret-admin-bars">
          <?php foreach ($giro_chart as $row): ?>
          <div class="ret-admin-bar-row">
            <div class="ret-admin-bar-label"><?=$row['label']?></div>
            <div class="ret-admin-bar-track">
              <div class="ret-admin-bar-fill" style="width: <?=$row['percent']?>%"></div>
            </div>
            <div class="ret-admin-bar-value"><?=$row['total']?></div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="ret-admin-empty">No hay datos disponibles para este resumen.</p>
        <?php endif; ?>
      </article>

      <article class="ret-admin-card ret-admin-panel ret-admin-panel-half">
        <h2>Registros por Municipio</h2>
        <p>Municipios con mayor actividad reciente en el RET.</p>
        <?php if (! empty($municipio_chart)): ?>
        <div class="ret-admin-bars">
          <?php foreach ($municipio_chart as $row): ?>
          <div class="ret-admin-bar-row">
            <div class="ret-admin-bar-label"><?=$row['label']?></div>
            <div class="ret-admin-bar-track">
              <div class="ret-admin-bar-fill" style="width: <?=$row['percent']?>%"></div>
            </div>
            <div class="ret-admin-bar-value"><?=$row['total']?></div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="ret-admin-empty">No hay datos disponibles para este resumen.</p>
        <?php endif; ?>
      </article>

      <article class="ret-admin-card ret-admin-panel ret-admin-panel-half">
        <h2>Actividad de los últimos 7 días</h2>
        <p>Inscripciones visibles registradas por día.</p>
        <?php if (! empty($daily_series)): ?>
        <div class="ret-admin-trend">
          <?php foreach ($daily_series as $point): ?>
          <div class="ret-admin-trend-item">
            <strong><?=$point['total']?></strong>
            <div class="ret-admin-trend-bar" style="height: <?=$point['percent']?>%"></div>
            <span><?=$point['label']?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="ret-admin-empty">No hay registros suficientes para mostrar la tendencia.</p>
        <?php endif; ?>
      </article>

      <article class="ret-admin-card ret-admin-panel ret-admin-panel-half">
        <h2>Accesos rápidos</h2>
        <p>Atajos directos a las vistas operativas más consultadas por el equipo.</p>
        <div class="ret-admin-bars">
          <div class="ret-admin-bar-row">
            <div class="ret-admin-bar-label">Pendientes</div>
            <div><a href="<?=BASE_URL?>paneladm/pendientes">Abrir registros incompletos</a></div>
            <div class="ret-admin-bar-value"><i class="fa fa-arrow-right"></i></div>
          </div>
          <div class="ret-admin-bar-row">
            <div class="ret-admin-bar-label">Concluidos</div>
            <div><a href="<?=BASE_URL?>paneladm/concluidos">Revisar listos para aprobar</a></div>
            <div class="ret-admin-bar-value"><i class="fa fa-arrow-right"></i></div>
          </div>
          <div class="ret-admin-bar-row">
            <div class="ret-admin-bar-label">Aprobados</div>
            <div><a href="<?=BASE_URL?>paneladm/aprobados">Ver cédulas vigentes</a></div>
            <div class="ret-admin-bar-value"><i class="fa fa-arrow-right"></i></div>
          </div>
          <div class="ret-admin-bar-row">
            <div class="ret-admin-bar-label">Renovaciones</div>
            <div><a href="<?=BASE_URL?>paneladm/renovaciones">Dar seguimiento a renovaciones</a></div>
            <div class="ret-admin-bar-value"><i class="fa fa-arrow-right"></i></div>
          </div>
        </div>
      </article>

      <article class="ret-admin-card ret-admin-panel">
        <h2>Trámites recientes</h2>
        <p>Últimos registros visibles con acceso directo al expediente.</p>
        <?php if (! empty($recent_records)): ?>
        <table class="ret-admin-table">
          <thead>
            <tr>
              <th>Clave</th>
              <th>Nombre comercial</th>
              <th>Giro</th>
              <th>Municipio</th>
              <th>Correo</th>
              <th>Registro</th>
              <th>Estatus</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_records as $row): ?>
              <?php $status = $statusClass($row); ?>
            <tr>
              <td><a href="<?=BASE_URL?>paneladm/ver/<?=$row['clave']?>"><?=$row['clave']?></a></td>
              <td><?=$row['nombre_comercial'] ?: 'Sin nombre'?></td>
              <td><?=$row['g_giro'] ?: 'Sin giro'?></td>
              <td><?=$row['municipio_nombre'] ?: 'Sin municipio'?></td>
              <td><?=$row['correo'] ?: 'Sin correo'?></td>
              <td><?=$row['dg_fecha_registro_alt'] ?: 'Sin fecha'?></td>
              <td><span class="ret-status-pill <?=$status['class']?>"><?=$status['label']?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <p class="ret-admin-empty">No hay trámites visibles para mostrar en este momento.</p>
        <?php endif; ?>
      </article>
    </div>
  </section>
</div>
