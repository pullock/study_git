<?php

    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

    if (!CModule::IncludeModule("iblock")){
        ShowError();
        return;
    }

    $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 1, "ACTIVE" => "Y"), false, array("nPageSize" => 10));

    $arResult = array();

    while ($ob = $res->GetNextElement()){
        $fields = $ob->GetFields();
        $props = $ob->GetProperties();

        $itemData = array(
            'ID' => $fields["ID"],
            "NAME" => $fields["NAME"],
            "DETAIL_PAGE_URL" => $fields["DETAIL_PAGE_URL"],
            "PREVIEW_TEXT" => $fields["PREVIEW_TEXT"],
            "PROPETRY_VALUES" => $props,
        );

        $arResult[] = $itemData;
    }

    $this->IncludeComponentTemplate();
?>