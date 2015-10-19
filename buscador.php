<?php
$user="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["user"])) {
     $nameErr = "Name is required";
	echo $nameErr;
   }else{
	$user=$_POST["user"];
   }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	Buscador: <input type="text" name="user" value="<?php echo $user;?>">
	<input type="submit" name="submit" value="Buscar">
</form>
<?php

echo "<h1>Buscador - Extraccion de informacion</h1>";

$usuario = "cn=admin,dc=example,dc=com";
$pass = "eladmin23";

$ds = ldap_connect("127.0.0.1");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

	if ($ds){
		$a=ldap_bind($ds, $usuario, $pass);
		if($a){
			$buscar ="(&(uid=".$user.")(description=mod))";
			echo "query:  ".$buscar."<p>";
			$sr = ldap_search($ds, "dc=example, dc=com",$buscar);
			$info = ldap_get_entries($ds, $sr);

			for ($i=0; $i<$info["count"]; $i++) {
				echo "Nombre de la entrada: ".$info[$i]["dn"] ."<br>";
				echo "Apellidos: ". $info[$i]["sn"][0]."<br>";
				echo "Apodo: ".$info[$i]["givenname"][0] ."<br>";
				echo "Rango: ".$info[$i]["description"][0] ."<br>";
				echo "Telefono: ".$info[$i]["telephonenumber"][0] ."<br>";
				echo "Mail:".$info[$i]["mail"][0]."<p>";
			}
		} else{
			echo "No Autenticado";
		}
	}
	
	ldap_close($ds);
?>		