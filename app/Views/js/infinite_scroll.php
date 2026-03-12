<script>
    let page                =   1;
    let city                =   "<?=$busqueda['city']?>";
    let service             =   "<?=$busqueda['service']?>";
    let category            =   "<?=$busqueda['category']?>";
    let dist_h              =   "<?=$busqueda['dist_h']?>";
    let tesoros             =   "<?=$busqueda['tesoros']?>";
    let iso                 =   "<?=$busqueda['iso']?>";
    let dist_m              =   "<?=$busqueda['dist_m']?>";
    let punto_limpio        =   "<?=$busqueda['punto_limpio']?>";
    let anfitrion           =   "<?=$busqueda['anfitrion']?>";
    let competencia         =   "<?=$busqueda['competencia']?>";
    let isLoading           =   false;

    function textToImage(text, canvasElement) {
        const canvas        =   document.getElementById(`${canvasElement}`);
        const ctx           =   canvas.getContext('2d');

        const fontSize      =   '14px';
        const fontFamily    =   'Arial';
        const fontWeight    =   'bold';
        const textColor     =   'black';

        ctx.font            =   `${fontWeight} ${fontSize} ${fontFamily}`;
        ctx.fillStyle       =   textColor;

        const textWidth     =   ctx.measureText(text).width;
        const x             =   3;
        const y             =   15;

        ctx.fillText(text, x, y);

        return canvas;
    }

    function loadData() {
        if (isLoading) return;
        isLoading = true;
        $('#loader').show();

        grecaptcha.ready(function() {
            grecaptcha.execute('<?=SITE_KEY?>', {action: 'submit'}).then(function(token) {

                $.post('consulta-ciudadana/listado', { page: page, city: city, service: service, category: category, dist_h: dist_h, tesoros: tesoros, iso: iso, dist_m: dist_m, punto_limpio: punto_limpio, anfitrion: anfitrion, competencia: competencia, token: token }, function (data) {
                    $('#loader').hide();
                    if (data.length > 0) {
                        data.forEach(function (item) {
                            const itemHTML = `
                                    <div class="col">
                                        <div class="card bloq-provedor">
                                            <div class="card-header bgMarino bg-gradient text-white">
                                                <h6> <i class="bi bi-${item.icon_bs}"></i> ${item.giro} </h6>
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item" style="color:#FF8200"><i class="bi bi-qr-code"></i> ${item.clave} </li>
                                                <li class="list-group-item" style="color:blue"> ${item.nombre_comercial} </li> 
                                                <li class="list-group-item"><i class="bi bi-geo-alt" style="color:#FF8200"></i> ${item.calle} ${item.numero} ${item.colonia}</li>
                                                <li class="list-group-item"><i class="bi bi-geo" style="color:#FF8200"></i> ${item.municipio}</li>
                                                <li class="list-group-item"><i class="bi bi-telephone" style="color:#FF8200"></i> ${item.telefono}</li>                           
                                                <li class="list-group-item"><i class="bi bi-link-45deg" style="color:#FF8200"></i> ${item.web}</li>
                                                <li class="list-group-item" valign="center"><i class="bi bi-envelope" style="color:#FF8200"></i> <canvas id="${item.clave}" width="500" height="20"></canvas> </li>
                                            </ul>
                                        </div>          
                                    </div>
                            `;
                            $('#data-container').append(itemHTML);
                            const canvas = textToImage(`${item.correo}`,`${item.clave}`);
                        });
                        page++;
                        isLoading = false;
                    }
                }, 'json');

            });;
        });


    }

    loadData();

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadData();
        }
    });
</script>