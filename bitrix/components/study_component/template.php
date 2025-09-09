<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="simple-list">
    <?php if (!empty($arResult["ITEMS"])): ?>
        <?php foreach ($arResult["ITEMS"] as $item): ?>
            <div class="simple-item">
                <h3>
                    <a href="<?= htmlspecialcharsbx($item["DETAIL_PAGE_URL"]) ?>">
                        <?= htmlspecialcharsbx($item["NAME"]) ?>
                    </a>
                </h3>
                <p><?= htmlspecialcharsbx($item["PREVIEW_TEXT"]) ?></p>
                <small><?= $item["DATE_ACTIVE_FROM"] ?></small>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет элементов для отображения.</p>
    <?php endif; ?>
</div>