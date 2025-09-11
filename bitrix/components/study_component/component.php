<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Подключаем модуль инфоблоков
if (!CModule::IncludeModule("iblock")) {
    ShowError("Не удалось подключить модуль iblock");
    return;
}

// Устанавливаем фильтр по инфоблоку
$arFilter = [
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y"
];

// Выбираем нужные поля
$arSelect = [
    "ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "DATE_ACTIVE_FROM"
];

// Получаем элементы
$arResult["ITEMS"] = [];

$res = CIBlockElement::GetList(
    ["DATE_ACTIVE_FROM" => "DESC"], // сортировка по дате
    $arFilter,                      // фильтр
    false,                          // группировка
    ["nTopCount" => 10],            // максимум 10 элементов
    $arSelect                       // выбираемые поля
);

// Обрабатываем результат
while ($ob = $res->GetNext()) {
    $arResult["ITEMS"][] = $ob;
}

// Подключаем шаблон компонента
$this->IncludeComponentTemplate();