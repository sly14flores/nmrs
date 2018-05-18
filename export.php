<?php

$params = json_decode($_POST['params'],true);

$filter = $params;

require_once 'excel/PHPExcel.php';
require_once 'db.php';

$filename = "nmrs";

$where = "";

if ( (isset($filter['year'])) && (isset($filter['month'])) ) {
	
	$year = ($filter['year']=="")?"":$filter['year'];
	$month = $filter['month']['month'];

	$year_month = "'%$year-$month-%'";
	if ($month == "-") $year_month = "'$year-%'";
	
	$where = " WHERE DateRegistered LIKE $year_month";
	
};

$con = new pdo_db();

$sql = "SELECT CONCAT_WS(', ',`reg_jobseekers`.`LastName`, CONCAT_WS(' ',`reg_jobseekers`.`FirstName`, CONCAT_WS('.', SUBSTRING(`reg_jobseekers`.`MiddleName`, 1, 1), ''))) AS NAME, OccupationalSkill,    Occ_Code, Sex, Age, CivilStat, EducAttain, YearsofWorkExp, PhoneNo, Licence, DATE_FORMAT(DateRegistered,'%b %d %Y') AS DateRegistered, JobPlacement, Job, School, DATE_FORMAT(DateOfBirth,'%b %d %Y') AS BirthDate, YearGraduated, EmailAddress, Address, Height, Weight, Emp_Stat FROM nmrs.reg_jobseekers $where ORDER BY NAME ASC";

$profiles = $con->getData($sql);

$indexes = [];

if (count($profiles)) {

	foreach ($profiles[0] as $p => $value) {

		$indexes[] = $p;

	};

};

if (!count($indexes)) {
	
	echo "No records found";
	
	exit();
	
};

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("NMRS System")
							 ->setLastModifiedBy("NMRS System")
							 ->setTitle("Profiles")
							 ->setSubject("Profiles Report")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("Reports");

$objWorksheet = $objPHPExcel->getActiveSheet();

$row = 1;
foreach ($indexes as $i => $index) {

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $row, $index);
	
};

$columns = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U");
$objPHPExcel->getDefaultStyle()->getFont()->setSize(14);
for ($n=0; $n<count($columns); ++$n) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columns[$n])->setAutoSize(true);
}

$objPHPExcel->getActiveSheet()->getRowDimension("1")->setRowHeight(25);

$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('8A8A8A');

$row++;
foreach ($profiles as $key => $profile) {

	$i = 0;

	foreach ($profile as $c => $value) {
		
		$value = ($value==NULL)?"":$value;

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $row, $value);	

		++$i;

	};

	$row++;

};

$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename."-".date("Y_m_d").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>