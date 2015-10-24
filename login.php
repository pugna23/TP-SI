<?php
 echo "<h1>Ejercicio no4 - Bypass login con asteriscos</h1>";

 $usuario = "cn=admin,dc=example,dc=com";
 $pass = "eladmin23";

 $ds = ldap_connect("127.0.0.1");
 ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);


if ($ds){

	$a=ldap_bind($ds, $usuario, $pass);
	if ($a){
		$buscar = "(&(uid=".$_GET['uid'].")(userPassword=".$_GET['p']."))";
	
		/*CONTRAMEDIDA
		$buscar = str_replace("*","",$buscar);
		*/
	
		echo $buscar."<p>";
		$sr = ldap_search($ds, "dc=example, dc=com","$buscar");
		$info = ldap_get_entries($ds, $sr);
		if ($info["count"] == 1){
			echo '<font color="green">¡Has iniciado sesión correctamente!</font><p>';
			for ($i=0; $i<$info["count"]; $i++) {
				echo "Nombre de la entrada: ".$info[$i]["dn"] ."<br>";
				echo "Apellidos: ". $info[$i]["sn"][0]."<br>";
				echo "Apodo: ".$info[$i]["givenname"][0] ."<br>";
				echo "Rango: ".$info[$i]["description"][0] ."<br>";
				echo "Telefono: ".$info[$i]["telephonenumber"][0] ."<br>";
				echo "Mail:".$info[$i]["mail"][0]."<p>";
			}
		} else {
			echo '<font color="red">¡ERROR! El usuario o contraseña son incorrectos</font>';
		}
	} else {
		echo "No autenticado";
	}
}

ldap_close($ds);


?>
