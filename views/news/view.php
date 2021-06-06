<?php $pathinfo = pathinfo($model['photo']); ?>
<div class="news">
    <div>
        <? if(is_file('files/news/'.$pathinfo['filename'].'_m.'.$pathinfo['extension'])) : ?>
            <div class="mb-3">
                <? if(is_file('files/news/'.$pathinfo['filename'].'_b.'.$pathinfo['extension'])) : ?>
                    <a href="/files/news/<?= $pathinfo['filename'].'_b.'.$pathinfo['extension'] ?>" data-fancybox="gallery">
                <? endif; ?>
                    <img src="/files/news/<?= $pathinfo['filename'].'_m.'.$pathinfo['extension'] ?>" class="bd-placeholder-img rounded float-start">
                <? if(is_file('files/news/'.$pathinfo['filename'].'_b.'.$pathinfo['extension'])) : ?>
                    </a>
                <? endif; ?>
            </div>
        <? endif ?>
    </div>
    <div>
        <?= $model['text'] ?>
    </div>
</div>
