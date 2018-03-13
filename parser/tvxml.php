<html><head></head><body>
<?
echo 'ркут';
$xmlstr = "http://www.putzmeister.ru/service/spares/rastvoronasosy/smesiteli_dlya_modelej_m_730/lopasti_smesitelya_dlya_m730.xml";
var_dump($xmlstr);
$page = new SimpleXMLElement($xmlstr);
var_dump($page);
?>
</body></html>