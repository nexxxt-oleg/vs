<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); $arComponentDescription = array(
"NAME" => 'Вывод кода',
"DESCRIPTION" => GetMessage('Выводит код as-is'),
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "mix8872",
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "sourcecode",
			),
		),
	),
);
?>