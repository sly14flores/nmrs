<?php

$params = json_decode($_POST['params'],true);

$filter = $params;

require_once 'excel/PHPExcel.php';
require_once 'db.php';

$filename = "nmrs";

$indexes = [
	"category",
	"personal_info_no",
	"lastname",
	"firstname",
	"middlename",
	"extension_name",
	"civil_status",
	"gender",
	"birth_date",
	"birth_place",
	"age",
	"family_head",
	"family_members",
	"employment_status",
	"occupation",
	"philhealth_member",
	"address_house",
	"address_sitio",
	"address_purok",
	"address_barangay",
	"address_municipality",
	"address_province",
	"contact_no",
	"contact_email",
	"educational_attainment",
	"presented_id",
	"presented_id_no"
];


$con = new pdo_db();

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("ILMB System")
							 ->setLastModifiedBy("ILMB System")
							 ->setTitle("Profiles")
							 ->setSubject("Profiles Report")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("Reports");

$objWorksheet = $objPHPExcel->getActiveSheet();

/* $attendances = $con->getData("SELECT category, personal_info_no, lastname, firstname, middlename, extension_name, civil_status, gender, birth_date, birth_place, age, family_head, family_members, employment_status, occupation, philhealth_member, address_house, address_sitio, address_purok, address_barangay, address_municipality, address_province, contact_no, contact_email, educational_attainment, presented_id, presented_id_no FROM personal_infos WHERE attendance = 1");
$profiles = $con->getData("SELECT category, personal_info_no, lastname, firstname, middlename, extension_name, civil_status, gender, birth_date, birth_place, age, family_head, family_members, employment_status, occupation, philhealth_member, address_house, address_sitio, address_purok, address_barangay, address_municipality, address_province, contact_no, contact_email, educational_attainment, presented_id, presented_id_no FROM personal_infos");

foreach ($attendances as $i => $profile) {
	
	$row = $i+2;
	foreach ($indexes as $ii => $index) {
		$value = (($profile[$indexes[$ii]]==NULL)||($profile[$indexes[$ii]]==""))?"":$profile[$indexes[$ii]];
		if ($indexes[$ii] == "birth_date") {
			$value = ($profile[$indexes[$ii]]=="1970-01-01")?"":$profile[$indexes[$ii]];
		}
		if ($indexes[$ii] == "address_barangay") {
			$value = barangay($profile[$indexes[$ii]]);
		}
		if ($indexes[$ii] == "address_municipality") {
			$value = municipality($profile[$indexes[$ii]]);
		}
		if ($indexes[$ii] == "address_province") {
			$value = "La Union";
		}
		if (($indexes[$ii] == "family_head") || ($indexes[$ii] == "philhealth_member")) {
			$value = ($profile[$indexes[$ii]])?"Yes":"No";
		}		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($ii, $row, $value);
	}
	
};

foreach ($profiles as $i => $profile) {
	
	$row = $i+2;
	foreach ($indexes as $ii => $index) {
		$value = (($profile[$indexes[$ii]]==NULL)||($profile[$indexes[$ii]]==""))?"":$profile[$indexes[$ii]];
		if ($indexes[$ii] == "birth_date") {
			$value = ($profile[$indexes[$ii]]=="1970-01-01")?"":$profile[$indexes[$ii]];
		}
		if ($indexes[$ii] == "address_barangay") {
			$value = barangay($profile[$indexes[$ii]]);
		}
		if ($indexes[$ii] == "address_municipality") {
			$value = municipality($profile[$indexes[$ii]]);
		}
		if ($indexes[$ii] == "address_province") {
			$value = "La Union";
		}
		if (($indexes[$ii] == "family_head") || ($indexes[$ii] == "philhealth_member")) {
			$value = ($profile[$indexes[$ii]])?"Yes":"No";
		}		
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($ii, $row, $value);
	}
	
}; */

$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename."-".date("Y_m_d").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>