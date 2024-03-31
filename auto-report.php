<?
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

CModule::IncludeModule('iblock');

//month names array
$month_names = array(
    "01" => "январь",
    "02" => "февраль",
    "03" => "март",
    "04" => "апрель",
    "05" => "май",
    "06" => "июнь",
    "07" => "июль",
    "08" => "август",
    "09" => "сентябрь",
    "10" => "октябрь",
    "11" => "ноябрь",
    "12" => "декабрь",
);

//check current elements for prevent doubles
$current_reports_array = array();
$current_reports_bx = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 39), false, false, Array("NAME"));
while ($cur = $current_reports_bx->GetNext())
{
    $current_reports_array[] = $cur["NAME"];
}

$project_names = array("О-камень", "Бетонекс", "Выкупимвашавтомобиль.рф", "Eprussia", "Outletwheels", "ЛЭП", "Kaiyi-forpost", "FAW-forpost", "Chery-forpost", "Geely-forpost", "Стройгидроспас");
foreach ($project_names as $project_index => $project) {
    $el = new CIBlockElement;

    $date_mark_month = date("m", strtotime("first day of last month"));
    $date_mark_year = date("Y", strtotime("first day of last month"));

    $pro_name_formatted = "Отчет ".$project." ".$month_names[$date_mark_month]." ".$date_mark_year;

    if (array_search($pro_name_formatted, $current_reports_array) !== false) {
        echo "<span style='color:red;'>Отчет с названием '".$pro_name_formatted."' уже присутствует в системе</span><br>";
        continue;
    }

    $pr_props = array (
        "MODIFIED_BY" => $USER->GetID(),
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID"      => 39,
        "NAME" => $pro_name_formatted,
        "ACTIVE" => "Y",
    );

    if($el->Add($pr_props)) {
        echo "<span style='color:green;'>".$pro_name_formatted." добавлен в систему</span><br>";
    }
}
echo "Работа скрипта завершена";
?>