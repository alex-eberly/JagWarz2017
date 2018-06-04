<?php include("../includes/dataObjects.php"); ?>
<?php include '../includes/tableStructure.php' ?>
<?php 
$dbserver = "";
$db = "";
$user = "";
$password = "";
$table = "";
$includeDbConnection = 0;
if (isset($_POST["dbServer"])) 
{
	$dbserver = $_POST["dbServer"];
}
if (isset($_POST["database"])) 
{
	$db = $_POST["database"];
}
if (isset($_POST["username"])) 
{
	$user = $_POST["username"];
}
if (isset($_POST["password"])) 
{
	$password = $_POST["password"];
}
if (isset($_POST["table"]))
{
	$table = $_POST["table"];
}
if (isset($_POST["includeDbConnection"]))
{
	$includeDbConnection = $_POST["includeDbConnection"];
}
$conn = mysql_connect($dbserver,$user,$password);
if ($conn)
{
	mysql_select_db($db, $conn);
	$sql = " select column_name, is_nullable, data_type,character_maximum_length,extra from INFORMATION_SCHEMA.columns where table_name = '" . $table . "' and table_schema = '" . $db . "'"; 
	//this function will execute the sql satament
	$result=mysql_query($sql);
	$TableStructureArray = Array();
	while($row = mysql_fetch_array($result)) // getting data
	{
		$TableStructure = new TableStructure();
		$TableStructure->ColumnName = $row['column_name'];
		$TableStructure->TypeName = $row['data_type'];
		$TableStructure->MaxLength = $row['character_maximum_length'];
		$TableStructure->IsNullable = $row['is_nullable'];
		$TableStructure->IsIdentity = $row['extra'];
		$TableStructureArray[] = $TableStructure;
	}
	$classFilename = '../temp/' . $table . ".gen.php";
	$classFilenameHandler = fopen($classFilename, 'w') or die("can't open file");
	//write out the class based on the db object
	$classContents = "<?php\n";
	if ($includeDbConnection == 1) 
	{
		//globals
		$classContents .= "//Globals\n";
		$classContents .= "\$dbserver = \"$dbserver\";\n";
		$classContents .= "\$db = \"$db\";\n";
		$classContents .= "\$dbuser = \"$user\";\n";
		$classContents .= "\$dbpassword = \"$password\";\n";
	}
	//usage
	$classContents .= "//Usage\n";
	$classContents .= "/*\n";
	$classContents .= "<?php include '" . $table . ".gen.php' ?>\n";
	$classContents .= "<?php\n";
	$classContents .= "\$" . $table . "Factory = new " . $table . "Factory();\n";
	$classContents .= "\$" . $table . " = \$" . $table . "Factory->GetOne(1);\n";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		$i++;
		if ($i == 2)
		{
			$classContents .= "echo \$" . $table . "->" . $value->ColumnName . " . \"<br />\";\n";
		}
	}
	$classContents .= "unset(\$" . $table . ");\n";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		$i++;
		if ($i == 1)
		{
			$classContents .= "\$" . $table . "Array = \$" . $table . "Factory->GetAll(' where " . $value->ColumnName . " = 1 ');\n";
		}
	}
	$classContents .= "foreach (\$" . $table . "Array as &\$value)\n";
	$classContents .= "{\n";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		$i++;
		if ($i == 2)
		{
			$classContents .= "\techo \$value->" . $value->ColumnName . " . \"<br />\";\n";
		}
	}
	$classContents .= "}\n";
	$classContents .= "unset(\$value);\n";
	$classContents .= "?>\n";
	$classContents .= "*/\n";
	//write out class
	$classContents .= "//Core Class\n";
	$classContents .= "class " . $table . "\n";
	$classContents .= "{\n";
	foreach ($TableStructureArray as &$value)
	{
		$classContents .= "\tvar $" . $value->ColumnName . ";\n";
	}
	foreach ($TableStructureArray as &$value)
	{
		$classContents .= "\tfunction set" . $value->ColumnName . "($" . $value->ColumnName . ")\n";
		$classContents .= "\t{\n";
		$classContents .= "\t\t\$this->" . $value->ColumnName . " = $" . $value->ColumnName . ";\n";
		$classContents .= "\t}\n";
		$classContents .= "\tfunction get" . $value->ColumnName . "()\n";
		$classContents .= "\t{\n";
		$classContents .= "\t\treturn \$this->" . $value->ColumnName . ";\n";
		$classContents .= "\t}\n";
	}
	$classContents .= "}\n";
	//write out factory
	$classContents .= "//Factory Class\n";
	$classContents .= "class " . $table . "Factory\n";
	$classContents .= "{\n";
	//write out get one method
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		$i++;
		if ($i == 1)
		{
			$classContents .= "\tfunction GetOne($" . $value->ColumnName . ")\n";
		}
	}
	$classContents .= "\t{\n";
	$classContents .= "\t\t$" . $table . " = new " . $table . "();\n";
	$classContents .= "\t\tglobal \$dbserver,\$db,\$dbuser,\$dbpassword;\n";
	$classContents .= "\t\t\$conn = mysql_connect(\$dbserver,\$dbuser,\$dbpassword);\n";
	$classContents .= "\t\tif (\$conn)\n";
	$classContents .= "\t\t{\n";
	$classContents .= "\t\t\tmysql_select_db(\$db, \$conn);\n";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		$i++;
		if ($i == 1)
		{
			$classContents .= "\t\t\t\$sql = \"select * from " . $table . " where " . $value->ColumnName . " = \" . mysql_real_escape_string(\$" . $value->ColumnName . ");\n"; 
		}
	}
	$classContents .= "\t\t\t\$result=mysql_query(\$sql);\n";
	$classContents .= "\t\t\twhile(\$row = mysql_fetch_array(\$result))\n";
	$classContents .= "\t\t\t{\n";
	foreach ($TableStructureArray as &$value)
	{
		if ($value->IsNullable == 'YES')
		{
			$classContents .= "\t\t\t\t$" . $table . "->" . $value->ColumnName . " = (\$row['" . $value->ColumnName . "'] === NULL) ? \"NULL\" : \$row['" . $value->ColumnName . "'];\n";
		}
		else
		{
			$classContents .= "\t\t\t\t$" . $table . "->" . $value->ColumnName . " = \$row['" . $value->ColumnName . "'];\n";
		}
	}
	$classContents .= "\t\t\t}\n";
	$classContents .= "\t\t}\n";
	$classContents .= "\t\tmysql_close (\$conn);\n";
	$classContents .= "\t\treturn $" . $table . ";\n";
	$classContents .= "\t}\n";
	//write out get all method
	$classContents .= "\tfunction GetAll(\$filter)\n";
	$classContents .= "\t{\n";
	$classContents .= "\t\t$" . $table . "Array = Array();\n";
	$classContents .= "\t\tglobal \$dbserver,\$db,\$dbuser,\$dbpassword;\n";
	$classContents .= "\t\t\$conn = mysql_connect(\$dbserver,\$dbuser,\$dbpassword);\n";
	$classContents .= "\t\tif (\$conn)\n";
	$classContents .= "\t\t{\n";
	$classContents .= "\t\t\tmysql_select_db(\$db, \$conn);\n";
	$classContents .= "\t\t\t\$sql = \"select * from " . $table . " \" . \$filter;\n"; 
	$classContents .= "\t\t\t\$result=mysql_query(\$sql);\n";
	$classContents .= "\t\t\twhile(\$row = mysql_fetch_array(\$result))\n";
	$classContents .= "\t\t\t{\n";
	$classContents .= "\t\t\t\t$" . $table . " = new " . $table . "();\n";
	foreach ($TableStructureArray as &$value)
	{
		if ($value->IsNullable == 'YES')
		{
			$classContents .= "\t\t\t\t$" . $table . "->" . $value->ColumnName . " = (\$row['" . $value->ColumnName . "'] === NULL) ? \"NULL\" : \$row['" . $value->ColumnName . "'];\n";
		}
		else
		{
			$classContents .= "\t\t\t\t$" . $table . "->" . $value->ColumnName . " = \$row['" . $value->ColumnName . "'];\n";
		}
	}
	$classContents .= "\t\t\t\t$" . $table . "Array[] = $" . $table . ";\n";
	$classContents .= "\t\t\t}\n";
	$classContents .= "\t\t}\n";
	$classContents .= "\t\tmysql_close (\$conn);\n";
	$classContents .= "\t\treturn $" . $table . "Array;\n";
	$classContents .= "\t}\n";
	//write insert method
	$classContents .= "\tfunction Insert(\$" . $table . ")\n";
	$classContents .= "\t{\n";
	$classContents .= "\t\tglobal \$dbserver,\$db,\$dbuser,\$dbpassword;\n";
	$classContents .= "\t\t\$conn = mysql_connect(\$dbserver,\$dbuser,\$dbpassword);\n";
	$classContents .= "\t\tif (\$conn)\n";
	$classContents .= "\t\t{\n";
	$classContents .= "\t\t\tmysql_select_db(\$db, \$conn);\n";
	$classContents .= "\t\t\t\$insert = \"\";\n";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		if ($i > 0)
		{
			if ($i == count($TableStructureArray) - 1)
			{
				if ($value->TypeName == "varchar" | $value->TypeName == "datetime" | $value->TypeName == "char" | $value->TypeName == "text")
				{
					$classContents .= "\t\t\t\$insert .= \"'\" . mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ") . \"'\";\n";
				}
				else
				{
					$classContents .= "\t\t\t\$insert .= mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ");\n";
				}
			}
			else 
			{
				if ($value->TypeName == "varchar" | $value->TypeName == "datetime" | $value->TypeName == "char" | $value->TypeName == "text")
				{
					$classContents .= "\t\t\t\$insert .= \"'\" . mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ") . \"',\";\n";
				}
				else
				{
					$classContents .= "\t\t\t\$insert .= mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ") . \",\";\n";
				}
			}
		}
		$i++;
	}
	$classContents .= "\t\t\t\$sql = \"insert into " . $table . " (";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		if ($i > 0)
		{
			if ($i == count($TableStructureArray) - 1)
			{
				$classContents .= $value->ColumnName;
			}
			else 
			{
				$classContents .= $value->ColumnName . ",";
			}
		}
		$i++;
	}
	$classContents .= ") values (\" . \$insert . \")\";\n"; 
	$classContents .= "\t\t\tmysql_query(\$sql);\n"; 
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		if ($i == 0)
		{
			$classContents .= "\t\t\t\$" . $table . "->" . $value->ColumnName . " = mysql_insert_id();\n";
		}
		$i++;
	}
	$classContents .= "\t\t}\n";
	$classContents .= "\t\tmysql_close (\$conn);\n";
	$classContents .= "\t\treturn $" . $table . ";\n";
	$classContents .= "\t}\n";
	//write update method
	$classContents .= "\tfunction Update(\$" . $table . ")\n";
	$classContents .= "\t{\n";
	$classContents .= "\t\tglobal \$dbserver,\$db,\$dbuser,\$dbpassword;\n";
	$classContents .= "\t\t\$conn = mysql_connect(\$dbserver,\$dbuser,\$dbpassword);\n";
	$classContents .= "\t\tif (\$conn)\n";
	$classContents .= "\t\t{\n";
	$classContents .= "\t\t\tmysql_select_db(\$db, \$conn);\n";
	$classContents .= "\t\t\t\$update = \"\";\n";
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		if ($i > 0)
		{
			if ($i == count($TableStructureArray) - 1)
			{
				if ($value->TypeName == "varchar" | $value->TypeName == "datetime" | $value->TypeName == "char" | $value->TypeName == "text")
				{
					$classContents .= "\t\t\t\$update .= \"" . $value->ColumnName . " = '\" . mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ") . \"'\";\n";
				}
				else
				{
					$classContents .= "\t\t\t\$update .= \"" . $value->ColumnName . " = \" . mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ");\n";
				}
			}
			else 
			{
				if ($value->TypeName == "varchar" | $value->TypeName == "datetime" | $value->TypeName == "char" | $value->TypeName == "text")
				{
					$classContents .= "\t\t\t\$update .= \"" . $value->ColumnName . " = '\" . mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ") . \"',\";\n";
				}
				else
				{
					$classContents .= "\t\t\t\$update .= \"" . $value->ColumnName . " = \" . mysql_real_escape_string($" . $table . "->" . $value->ColumnName . ") . \",\";\n";
				}
			}
		}
		$i++;
	}
	$i = 0;
	foreach ($TableStructureArray as &$value)
	{
		if ($i == 0)
		{
			$classContents .= "\t\t\t\$sql = \"update " . $table . " set \" . \$update . \" where " . $value->ColumnName . " = \" . mysql_real_escape_string(\$" . $table . "->" . $value->ColumnName . ");\n"; 
		}
		$i++;
	}
	$classContents .= "\t\t\tmysql_query(\$sql);\n";
	$classContents .= "\t\t}\n";
	$classContents .= "\t\tmysql_close (\$conn);\n";
	$classContents .= "\t}\n";
	//write file
	$classContents .= "}\n";
	$classContents .= "?>";
	fwrite($classFilenameHandler, $classContents);
	fclose($classFilenameHandler);
	//write out partial file
	$classFilename = '../temp/' . $table . ".php";
	$classFilenameHandler = fopen($classFilename, 'w') or die("can't open file");
	//write out the extended class based on the db object
	$classContents = "<?php\n";
	$classContents .= "class " . $table . "Extended extends " . $table . "\n";
	$classContents .= "{\n";
	$classContents .= "\t\n";
	$classContents .= "}\n";
	$classContents .= "?>";
	fwrite($classFilenameHandler, $classContents);
	fclose($classFilenameHandler);
	echo "<br /><strong>Download Generated Class: </strong><a href=\"handlers/download.php?filename=$table.gen.php\" target=\"_blank\">$table.gen.php</a><br /><strong>Download Generated Partial Class: </strong><a href=\"handlers/download.php?filename=$table.php\" target=\"_blank\">$table.php</a>";
}
mysql_close ($conn);
?>