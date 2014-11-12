<div class="columns">

    <div class="leftColumn">

        <div class="rightPadded">
            <h3>Анонсы</h3>
            <?php if ($_games->count() > 0): ?>
            <?php
            foreach ($_games as $game)
            {
                include_partial(
                    'gameAnnounce',
                    array(
                        'game' => $game,
                        '_isAuth' => $_userAuthenticated,
                        '_showRegions' => ($_currentRegion->id == Region::DEFAULT_REGION)
                    )
                );
            }
            ?>
            <?php else: ?>
            <p>
                В ближайшее время игр не планируется.
            </p>
            <?php endif; ?>  
        </div>

    </div><div class="centerColumn">

        <div class="bothPadded">
            <?php if (!$_userAuthenticated): ?>
            <p>
                Для участия Вам нужно <?php echo link_to('войти', 'auth/login')?>.
            </p>
            <p>
                Если Вы здесь впервые, то <?php echo link_to('зарегистрируйтесь', 'auth/register')?>.
            </p>
            <?php endif; ?>
        </div>
        <div class="hr">
            <?php echo ($homeArticle = Article::byName('Шаблонные-Главная')) ? Utils::decodeBB($homeArticle->text) : 'Заполните статью \'Шаблонные-Главная\''; ?>
        </div>

    </div><div class="rightColumn">

        <div class="leftPadded">
            <?php   if ($_canEditNews && $_localNews): ?>
            <div>
            <?php       render_h3_inline_begin("Новости") ?>
                <span class="safeAction"><?php echo link_to('Редактировать', 'article/edit?id='.$_localNews->id); ?></span>
            <?php       render_h3_inline_end() ?>
            </div>
            <?php   else: ?>
            <h3>Новости</h3>
            <?php   endif ?>

            <?php if ($_localNews): ?>
            <div>
                <?php echo Utils::decodeBB($_localNews->text) ?>
            </div>
            <?php else: ?>
            <?php   echo decorate_span('warn', 'Создайте для этого проекта новостной канал - статью "Новости"-'.$_currentRegion->name) ?>
            <?php endif ?>
        </div>

    </div>
  
</div>
