<?php
$journalsModel = new \models\Journals();
$userModel = new \models\Users();
?>
<? if($userModel->isUserAuthenticated() && !$userModel->isUserAccessIsUser()) : ?>
    <div class="mb-2 mt-2 align-right">
        <a  class="btn btn-success" href="/journals/add">Створити журнал</a>
    </div>
<? endif;?>
<div class="wrapper-journals-list">
    <div class="primary-school mt-4 mb-4">
        <div class="content">
            <h3>Початкові класи</h3>
            <div class="wrapper-classes">
                <? for($i = 1; $i <= 4; $i++): ?>
                    <div class="wrapper-class mb-2">
                        <div class="class text-center"><strong>Клас <?= $i ?>-А</strong></div>
                        <? foreach ($journalsModel->getSubjectByClass("{$i}-А") as $subject) : ?>
                            <div class="wrapper-subject">
                                <? if($userModel->isUserAuthenticated() && $userModel->isUserAccessIsEditor() || $userModel->isUserAccessIsAdmin()) : ?>
                                    <a href="/journals/edit?id=<?= $subject['id'] ?>" class="btn btn-primary">Edit</a>
                                <? endif; ?>
                                <div class="subject"><a href="journals/view?id=<?= $subject['id'] ?>"><?= $subject['subject'] ?></a></div>
                            </div>
                        <? endforeach; ?>
                    </div>
                <? endfor; ?>
            </div>
        </div>
    </div>

    <div class="primary-school mt-4 mb-2">
        <div class="content">
            <h3>Середні класи</h3>
            <div class="wrapper-classes">
                <? for($i = 5; $i <= 8; $i++): ?>
                    <div class="wrapper-class mb-2">
                        <div class="class text-center"><strong>Клас <?= $i ?>-А</strong></div>
                        <? foreach ($journalsModel->getSubjectByClass("{$i}-А") as $subject) : ?>
                            <div class="wrapper-subject">
                                <? if($userModel->isUserAuthenticated() && $userModel->isUserAccessIsEditor() || $userModel->isUserAccessIsAdmin()) : ?>
                                    <a href="/journals/edit?id=<?= $subject['id'] ?>" class="btn btn-primary">Edit</a>
                                <? endif; ?>
                                <div class="subject"><a href="journals/view?id=<?= $subject['id'] ?>"><?= $subject['subject'] ?></a></div>
                            </div>
                        <? endforeach; ?>
                    </div>
                <? endfor; ?>
            </div>
        </div>
    </div>

    <div class="primary-school mt-4 mb-4">
        <div class="content">
            <h3>Старші класи</h3>
            <div class="wrapper-classes">
                <? for($i = 9; $i <= 11; $i++): ?>
                    <div class="wrapper-class mb-2">
                        <div class="class text-center"><strong>Клас <?= $i ?>-А</strong></div>
                        <? foreach ($journalsModel->getSubjectByClass("{$i}-А") as $subject) : ?>
                            <div class="wrapper-subject">
                                <? if($userModel->isUserAuthenticated() && $userModel->isUserAccessIsEditor() || $userModel->isUserAccessIsAdmin()) : ?>
                                    <a href="/journals/edit?id=<?= $subject['id'] ?>" class="btn btn-primary">Edit</a>
                                <? endif; ?>
                                <div class="subject"><a href="journals/view?id=<?= $subject['id'] ?>"><?= $subject['subject'] ?></a></div>
                            </div>
                        <? endforeach; ?>
                    </div>
                <? endfor; ?>
            </div>
        </div>
    </div>

</div>
