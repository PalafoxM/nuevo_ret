<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cédula RET</title>
<style type="text/css">
body {
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
}

.cedulabg {
  background-image: url('<?=BASE_ROOT?>public/assets/images/cedula_2024-2030.png'); width: 1064px; height: 822px; max-height: 822px; max-width: 1064px;
}

.table_td1{
  width: 1064px; 
  height: 170px; 
  max-height: 170px;  
  font-family: chelvetica; 
  font-size: 12px;
  font-weight: bold;
}
.table_td2{
  width: 1064px; 
  height: 593px; 
  max-height: 593px;  
  font-family: chelvetica; 
  font-size: 12px;
  font-weight: bold;
}
.table_td3{
  width: 1064px; 
  height: 62px; 
  max-height: 62px;  
  font-family: chelvetica; 
  font-size: 12px;
  font-weight: bold;
}


</style>
</head>

<body>

<div class="cedulabg">
  <table width="1064" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="table_td1"></td>
    </tr>
    <tr>
      <td><div class="table_td2">
        <table width="1064" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="104"><table width="1064" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="664" height="104">&nbsp;</td>
              <td width="400" height="104"><table width="400" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="400" height="55" align="center" valign="bottom" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:45px; color:#0f406d;"><b><?=$cedula[0]['clave']?></b></td>
                </tr>
                <tr>
                  <td width="400" height="49">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="164"><table width="1064" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="307" height="56">&nbsp;</td>
              <td width="757" height="56" align="left" valign="bottom" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:22px; color:#0f406d; text-transform:uppercase;"><b><?=$cedula[0]['nombre_comercial']?><br><span style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:16px; color:#0f406d; text-transform:uppercase;"><?=$cedula[0]['razon_social']?></span></b></td>
            </tr>
            <tr>
              <td width="307" height="108">&nbsp;</td>
              <td width="757" height="108" align="left" valign="middle" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:16px; color:#0f406d; text-transform:uppercase;"><p><b><?=$cedula[0]['calle']?> #<?=$cedula[0]['numero']?><?=(($cedula[0]['interior'] != '')?' No. Int. '.$cedula[0]['interior']:'')?><br />
                <?=$cedula[0]['colonia']?><br />
                CP <?=$cedula[0]['cp']?> <?=$cedula[0]['municipio']?>, GUANAJUATO.</b></p></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="276"><table width="1064" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="307" height="276"><table width="307" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="307" height="84">&nbsp;</td>
                </tr>
                <tr>
                  <td width="307" height="45"><table width="307" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="267" height="45" align="right" valign="top" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:16px; color:#0f406d;"><b><?=(($cedula[0]['idgiro_subrubro'] != 0)?(($cedula[0]['giro'] == 1)?'          ':'          '):'')?></b></td>
                      <td width="40" height="45">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="307" height="152">&nbsp;</td>
                </tr>
              </table></td>
              <td width="418" height="276"><table width="418" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="418" height="84" align="left" valign="middle" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:22px; color:#0f406d; text-transform:uppercase;"><b><?=$cedula[0]['g_giro']?></b></td>
                </tr>
                <tr>
                  <td width="418" height="45" align="left" valign="top" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:16px; color:#0f406d; text-transform:uppercase;"><b><?=(($cedula[0]['idgiro_subrubro'] != 0)?$cedula[0]['subrubro_descripcion']:'')?></b></td>
                </tr>
                <tr>
                  <td width="418" height="152" align="left" valign="top" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:22px; color:#0f406d; text-transform:uppercase;"><b><?=$cedula[0]['fecha_alt']?><br />
                    <?=date("d/m/Y",strtotime(str_replace('/','-',$cedula[0]['fecha'])." + 3 year"))?></b></td>
                </tr>
              </table></td>
              <td width="339" height="276" align="center" valign="top"><img src="<?=$qrcode?>" height="140" width="140"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="44"><table width="1064" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="666" height="44"><table width="666" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="666" height="17" align="center" valign="top" style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:10px; color:#0f406d;"><b><?=(($cedula[0]['autoclasificacion'] != 'N/A' || $cedula[0]['autoclasificacion'] != '')?'':'')?></b></td>
                </tr>
                <tr>
                  <td width="666" height="27">&nbsp;</td>
                </tr>
              </table></td>
              <td width="398" height="0" align="left" valign="bottom"  style="font-family: chelvetica; font-weight: bold; font-weight:500; font-size:10px; color:#def0fa; word-wrap: break-word; max-width: 398px;"><b>SELLO DIGITAL: <?=wordwrap($cedula[0]['cadena_aprobacion'], 60, "<br />\n", true)?></b></td>
            </tr>
          </table></td>
        </tr>
        </table></div>
    </td>
    </tr>
    <tr>
      <td><div class="table_td3"></div></td>
    </tr>
  </table>
</div>

</body>
</html>

