<?php
$user="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["user"])) {
     $nameErr = "Name is required";
	echo $nameErr;
   }else{
	$user=$_POST["user"];
	$nme=$_POST["nme"];
   }
}
?>

<h2>Registro</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
<tr>
	<td>Nick:</td><td> <input class="ent" type="text" name="user" value="<?php echo $user;?>"></td>
</tr>
<tr>
	<td>Name:</td><td> <input class="ent" type="text" name="nme" value="<?php echo $nme;?>"></td>
</tr>
<tr>
	<td>Pass:</td><td> <input type="password" name="p" value="<?php echo $p;?>"></td>
</tr>
<tr>
	<td>Repeat Pass:</td><td> <input type="password" name="p" value="<?php echo $rp;?>"></td>
</tr>
</table>
	<input type="submit" name="submit" value="Verificar">
</form>

<?php

 $usuario = "cn=admin,dc=example,dc=com";
 $pass = "eladmin23";

 $ds = ldap_connect("127.0.0.1");
 ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);


if ($ds){

	$a=ldap_bind($ds, $usuario, $pass);
	if ($a){
		$buscar = "(&(uid=".$user.")(description=mod)(cn=".$nme."))";
	
		/*CONTRAMEDIDA
		$buscar = str_replace("*","",$buscar);
		*/
	
		echo $buscar."<p>";
		$sr = ldap_search($ds, "dc=example, dc=com","$buscar");
		$info = ldap_get_entries($ds, $sr);
		if ($info["count"] >= 1){
			echo '<font color="red">El Nick ya existe</font><p>';
			
		} else {
			echo '<font color="green">Nick Disponible</font>';
		}
	} else {
		echo "No autenticado";
	}
}

ldap_close($ds);


?>
