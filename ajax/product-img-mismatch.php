<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if ($REQUEST_METHOD === "POST") {

    $itemName = $HTTP_POST_VARS['name'];
    $itemName = strip_tags(trim($itemName));
    $itemID = $HTTP_POST_VARS['id'];
    $itemID = strip_tags(trim($itemID));
    $itemUrl = $HTTP_POST_VARS['url'];
    $itemUrl = strip_tags(trim($itemUrl));

    global $USER;
    if (!empty($USER->GetLogin())){
        $userName = !empty($USER->GetFullName()) ? $USER->GetFullName() : $USER->GetLogin();
        $userEmail = $USER->GetEmail();
    }
    else{
        $userName= 'Гость';
        $userEmail = '';
    }



    $time = ConvertTimeStamp(time()+CTimeZone::GetOffset(), "FULL");


    if(!empty($itemID) && !empty($itemName)){

        $itemName = '" '. $itemName .' "';
        $itemID = '(ID: '. $itemID .' )';

        $arEventFields = array(
            "DATE_CREATE" => $time,
            "CONTACT_EMAIL" => $userEmail,
            "CONTACT_NAME" => $userName,
            "PRODUCT_NAME" => $itemName,
            "PRODUCT_ID" => $itemID,
            "PRODUCT_DETAIL_PAGE" => $itemUrl,
        );

        CEvent::Send("PRODUCT_IMG_MISMATCH", "s1", $arEventFields);





        echo "success";
    }


    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
}
?>