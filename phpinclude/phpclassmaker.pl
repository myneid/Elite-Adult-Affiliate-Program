#!/usr/local/bin/perl

#make a php class

my $classname = 'TEMP';
my @attributes = ('username',
		'password',
		'dbtype',
		'database',
		'hostname',
		);


my $classname = 'Site';
my @attributes = ('id',
		'name',
		'description',
		'mainurl',
		'joinurl',
		'membersurl',
		);

my $pear = 1;
my $db = 1;

		

open(FILE, ">class$classname.inc.php") || die $!;
print FILE "<?php\n\n";
print FILE "require_once 'PEAR.php';\n" if $pear;
print FILE "require_once 'classMailerDB.inc.php';\n" if $db;
print FILE<<'EOP';
/**
 * short description of class
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package Mailer
*/
EOP
print FILE "class $classname ";
print FILE "extends PEAR" if $pear;
print FILE "\n{\n";

foreach(@attributes)
{
	print FILE "\t/**\n\t* description of $_\n\t*\@var\n\t*/\n";
	print FILE "\tvar \$$_;\n";
}

print FILE "\n";

print FILE "\t/**\n\t*determines weather this record was changed with the set accessor methods\n\t*\@var boolean\n\t*/\n";
print FILE "\t" . 'var $_modified = false;' . "\n\n";
print FILE << "EOP";
	/**
	* contains the PEAR DB object
	* \@var object
	*/
	var \$db;
	/**
	* if the current object record is a new one or one already in the database
	*\@var boolean
	*/
	var \$_record_exists = false;
EOP

print FILE <<"EOP";
	/**
	* Constructor
	*
	* \@access public
	*/
EOP
print FILE "\tfunction $classname(\$db = false)\n\t{\n";
print FILE "\t\t" . '$this->PEAR();' . "\n" if $pear;
print FILE << "EOP";

		if(!\$db)
		{
			\$mdb = new MailerDB();
			\$db = \$mdb->connect_to_db();
		}
		\$this->db = \$db;
EOP

print FILE "\t}\n";

print FILE <<"EOP";
	/**
	* Destructor
	*Descructor: this will call the _update function upon unset to tie changes into the database
	*
	* \@access private
	*/
EOP
print FILE "\tfunction _$classname()\n\t{\n";
print FILE <<"EOP";
		if(\$this->_modified)
			\$this->_update();
EOP
print FILE "\t}\n";

#accessormethods

foreach(@attributes)
{
	my $var = $_;
	$name = ucfirst($var);
	$name =~ s/_(\w)/uc($1)/eg;
	print FILE << "EOP";
	/**
	* Acessor function to set the $var variable
	*
	*\@param
	*\@access public
	*/
EOP
	print FILE "\tfunction set$name(\$$var)\n\t{\n\t\t" . '$this->_modified = true;' . "\n\t\t" . '$this->' . $var . " = \$$var;\n\t}\n";
		
}
foreach(@attributes)
{
	my $var = $_;
	$name = ucfirst($var);
	$name =~ s/_(\w)/uc($1)/eg;
	print FILE << "EOP";
	/**
	* Acessor function to get the $var variable
	*
	*\@access public
	*\@return
	*/
EOP

	print FILE "\tfunction get$name()\n\t{\n\t\t" . 'return $this->' . $var . ";\n\t}\n";
		
}
my $update_string = '';
my $insert_string = '';
my $insert_vals = '';
my $update_valarray = '';
my $insert_valarray = '';
foreach(@attributes)
{
	my $var = $_;
	$name = ucfirst($var);
	$name =~ s/_(\w)/uc($1)/eg;
	
	if($_ ne 'id')
	{
		$update_string .= "$_=?,";
		$update_valarray .= "\$this->get$name(),";
	}
	$insert_string .= "$_,";
	$insert_valarray .= "\$this->get$name(),";
	$insert_vals .= '?,';

}
chop($update_string);
chop($insert_string);
chop($insert_vals);
chop($insert_valarray);

$update_valarray .= '$this->getId()';

print FILE << "EOP";
	/**
	*this function will update or insert into the database as needed
	*
	*\@access private
	*/
	function _update()
	{
		\$query = '';
		\$valueArray = array();
		if(\$this->_record_exists)
		{
			//update
			\$query = "update $classname set $update_string where id=?";
			\$valueArray = array($update_valarray);
		}
		else
		{
			//insert
			if(\$this->getId() == '')
				\$this->setId(\$this->_generateNextId());

			\$query = "insert into $classname ($insert_string) values ($insert_vals)";
			\$valueArray = array($insert_valarray);
		}
		\$sth = \$this->db->prepare(\$query);
		\$res = \$this->db->execute(\$sth, \$valueArray);
		if(DB::isError(\$res))
		{
			trigger_error(\$res->getmessage(), E_USER_ERROR);
		}
		\$this->_modified = false;
		\$this->_record_exists = true;
	}
	/**
	this function will get the record by its id
	*
	*\@access public
	*/
	function getById(\$id = '')
	{
		if(\$id == '')
			\$id = \$this->getId();
		if(!\$id)
			trigger_error("you must set id to get by it", E_USER_ERROR);

		\$query = "select * from $classname where id=?";
		\$sth = \$this->db->prepare(\$query);
		\$res = \$this->db->execute(\$sth, array(\$id));

		\$row = \$res->fetchRow(DB_FETCHMODE_ASSOC);

EOP

foreach(@attributes)
{
	my $var = $_;
	$name = ucfirst($var);
	$name =~ s/_(\w)/uc($1)/eg;
	print FILE "\t\t\$this->set$name(\$row['$_']);\n";
}
print FILE <<"EOP";
		\$this->_record_exists = true;
		\$this->_modified = false;
	}
	
	/*
	*this function will generate the next id
	*
	*\@access private
	*/
	function _generateNextId()
	{
		return \$this->db->nextId("$classname", true);
	}
}

?>
EOP


