<style type="text/css">
#sitemanual div {counter-reset: h1}
#sitemanual .hndle:before {content:'';} 
#sitemanual h1 {counter-reset: h2}
#sitemanual h2 {counter-reset: h3}
#sitemanual h3 {counter-reset: h4}
#sitemanual h4 {counter-reset: h5}
#sitemanual h5 {counter-reset: h6}
#sitemanual h1:before {counter-increment: h1; content: counter(h1) ". "}
#sitemanual h2:before {counter-increment: h2; content: counter(h1) "." counter(h2) ". "}
#sitemanual h3:before {counter-increment: h3; content: counter(h1) "." counter(h2) "." counter(h3) ". "}
#sitemanual h4:before {counter-increment: h4; content: counter(h1) "." counter(h2) "." counter(h3) "." counter(h4) ". "}
#sitemanual h5:before {counter-increment: h5; content: counter(h1) "." counter(h2) "." counter(h3) "." counter(h4) "." counter(h5) ". "}
#sitemanual h6:before {counter-increment: h6; content: counter(h1) "." counter(h2) "." counter(h3) "." counter(h4) "." counter(h5) "." counter(h6) ". "}
#sitemanual h1.nocount:before, #sitemanual h2.nocount:before, #sitemanual h3.nocount:before, #sitemanual h4.nocount:before, #sitemanual h5.nocount:before, #sitemanual h6.nocount:before {content: ""; counter-increment: none}
#sitemanual h1 {font-size: 19px; font-weight:normal;}
#sitemanual h1, #sitemanual h2 {line-height: 1.4em}
#sitemanual ul {list-style:outside disc; padding-left: 2em; line-height:1.5; }
#sitemanual ul ul {padding-top:1.4em; padding-bottom:1.4em; }
#sitemanual li {margin:0; }
#sitemanual blockquote {color: #746E6E;}
#sitemanual blockquote p:before {content: 'Важно! '; font-weight:bold; font-style:italic; color:rgb(181, 53, 50);}
</style>

Сайт наполняется несколькими типами данных, а также готовыми страницами с различным дизайном и типами содержимого. Это:

- страницы с постоянным контентом, например, _главная страница_, _«Запись»_, _«Контакты»_ и т.д. (_раздел меню админки «Страницы»_);
- новости (_раздел меню админки «Записи»_);
- языки (_раздел меню админки «Языки»_);
- преподаватели (_раздел меню админки «Преподаватели»_).

#Публикация новостей на сайте

Публикация новостей осуществляется через раздел админки [Записи](/wordpress/wp-admin/edit.php), ссылку [Добавить новую](/wordpress/wp-admin/post-new.php). К новости необходимо добавить фото — правая колонка, блок _Миниатюра записи_. Фото должна быть выбрано с учетом того, что на разных страницах сайта оно может быть частично обрезано.

> Для новостей и других типов контента можно заносить **краткое содержание, вводку** к новости в блок _Краткая информация_ в основной колонке страницы редактирования новости. Вводка не должна совпадать с самим текстом, она должна обеспечивать быстрое понимание сути новости, суммировать ее. Кроме того, вводки обогащают и разнообразят внешний вид сайта.

К новостям можно добавлять галереи, которые отображаются со стрелками для листания фото. Для этого нужно нажать кнопку _Добавить медиафайл_, выбрать в открывшемся окне вкладку _Создать галерею_ (слева), отметить нужные фото и нажать _Вставить в запись_. В галерее должно быть не менее 2 фотографий.

#Постоянные страницы (_главная страница_, _«Запись»_, _«Контакты»_ и т.д.)

Публикация постоянных страниц осуществляется через раздел админки [Страницы](/wordpress/wp-admin/edit.php?post_type=page), ссылку [Добавить новую](/wordpress/wp-admin/post-new.php?post_type=page). Постоянные страницы в этом разделе бывают самостоятельными и вспомогательными. Последние — это страницы, чей контент используется на других, составных страницах, таких, как «Стоимость», «Преимущества» и т.д., и не отображается на сайте сам по себе. К составным страницам также иногда добавляется автоматически сгенерированная сайтом информация, не заносящаяся в админку. Вступительный текст составных страниц обычно редактируется на странице в админке с тем же названием, что и страницы на сайте. 

Контент составных страниц распределяется следующим образом:

- Главная страница —
	- блок «Как выучить иностранный язык?» — [страница в админке «Главная страница»](/wordpress/wp-admin/post.php?post=114&action=edit);
	- вступительный текст блока «Как мы обучаем иностранному языку?» — [страница в админке «Как мы обучаем иностранному языку?»](wp-admin/post.php?post=86&action=edit), блок _Краткая информация_;
	- описания модулей в блоке «Как мы обучаем иностранному языку?» — страницы модулей ([1](/wordpress/wp-admin/post.php?post=73&action=edit), [2](/wordpress/wp-admin/post.php?post=75&action=edit), [3](/wordpress/wp-admin/post.php?post=77&action=edit), [4](/wordpress/wp-admin/post.php?post=81&action=edit)). Изменить информацию, отображаемую в схеме, можно в блоках _Настройка модулей_ и _Краткая информация_;
	- текст и иконки блока «Как проходит обучение?» — [страница «Как проходит обучение?»](/wordpress/wp-admin/post.php?post=118&action=edit). Иконки можно заменять и перетаскивать, для этого нужно потащить их мышкой, однако всего их должно быть 6;
- Преимущества —
	- вступительный текст — [страница в админке «Преимущества»](wp-admin/post.php?post=16&action=edit);
	- вступительный текст инфографики модулей «Как мы обучаем иностранному языку?» — [страница в админке «Как мы обучаем иностранному языку?»](wp-admin/post.php?post=86&action=edit);
	- инфографика модулей — страницы модулей ([1](/wordpress/wp-admin/post.php?post=73&action=edit), [2](/wordpress/wp-admin/post.php?post=75&action=edit), [3](/wordpress/wp-admin/post.php?post=77&action=edit), [4](/wordpress/wp-admin/post.php?post=81&action=edit)). Изменить информацию, отображаемую в инфографике, можно в блоках _Настройка модулей_ и _Краткая информация_;
	- список модулей — там же. Текст до раскрывающей полный вид описания модуля ссылки («Подробно: чему учим, какие будут результаты») следует писать до тега _Далее (More)_. В случае необходимости этот тег можно вставить в текст кнопкой ![more](data:image/png;base64,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);
	- блоки «Подробнее о системе обучения в Linguamore» — раздел _Внешний вид->Виджеты->Подробнее о системе обучения в Linguamore_. Блоки можно менять местами, перетаскивая, но это нужно делать осторожно, проверяя, не нарушилась ли визуальная организация макета;
- Запись — эта страница может содержать текст и форму записи. Текст редактируется на [странице «Запись» админки](/wordpress/wp-admin/post.php?post=21&action=edit), а форма — в разделе [Contact Form 7](linguamore.ru/wordpress/wp-admin/admin.php?page=wpcf7). Форму следует редактировать с осторожностью, крайне не рекомендуется убирать или изменять содержащиеся в ней теги (латинский текст в скобках). Если какой-то из пунктов формы требуется убрать, это лучше сделать, удалив всю строку с этим пунктом целиком. Изменить адрес получателя заявок можно на вкладке _Письмо_ [страницы формы в админке](/wordpress/wp-admin/admin.php?page=wpcf7&post=38&action=edit) (поле _To_);
- Стоимость — эта (самостоятельная) страница может содержать вступительный текст, редактируемый на [странице «Стоимость» админки](/wordpress/wp-admin/post.php?post=209&action=edit), и автоматически генерируемые дополнительные блоки. По умолчанию текста нет, а информация в блоке «Месяц занятий — 7000 рублей» редактируется на вспомогательной странице админки [Стоимость курса](/wordpress/wp-admin/post.php?post=109&action=edit). Строчки текста в блоке, содержащие информацию о цифрах стоимости, генерируются автоматически на основании цифр, введенных на странице админки в блоке «Настройки страницы стоимости», последующий текст можно отредактировать в области контента там же.

При необходимости добавить новый модуль это можно сделать, создав обычную статическую страницу и выбрав в правой колонке страницы редактирования в блоке _Атрибуты страницы_, меню _Родительская_ пункт _Как мы обучаем иностранному языку?_. После сохранения страницы следует аккуратно заполнить все поля в появившемся блоке _Настройки модулей_.

#Языки и тесты

Добавить новый язык или отредактировать уже существующий можно в этом разделе админки. На странице языка можно: 

- изменить название, вступительный текст;
- изменить текст в скобках — в блоке «Краткая информация»;
- включить/убрать набор (блок _Настройки отображения страницы языка_, флажок _Набор закрыт?_). При выключенном наборе со страницы языка убирается блок «C чего начать?»;
- изменить фразу-call to action, отображаемую под фото преподавателей;
- привязать к языку занесенных в админку преподавателей — в правой колонке, блок _Связанные преподаватели_;
- выбрать картинку-заставку языка (вверху страницы) и картинку-символ (в середине страницы и на страницах тестов), а также цвета языка. Первым «фирменным» цветом языка помечается сумма скидки (_-35%_), вторым — фраза-call to action под портретом преподавателя;
- ввести вопросы для тестирования. Вопросов должно быть 24. Половина вопросов (любые, в любом порядке) должна быть помечена флажком _Вопрос только для продвинутой версии_. Тексты-описания уровней в тестах редактируются на страницах модулей — блок _Настройки модулей_, поле _Описание уровня, соответствующего этому модулю, в тесте_ на странице соответствующего уровню модуля (например, Intermediate = модуль 3). Описание нулевого и максимального уровней можно отредактировать на странице любого модуля, сдвинув ползунок _Выберите уровень модуля_ в том же блоке к левому или правому краю.

> При добавлении языка желательно нажать на кнопку _Изменить_ рядом с текстом _Постоянная ссылка_ под названием языка и ввести название языка на латинице (например, для японского — `japanese`). 

Стоимость нельзя поменять для каждого языка в отдельности, только для всех языков вместе (на странице админки [Стоимость курса](/wordpress/wp-admin/post.php?post=109&action=edit)). Информация о модулях изменяется на соответствующих страницах (см. выше). Иконки («Преодоление языкового барьера», «Погружение в культуру» и т.д.) можно изменить, загрузив в админку через раздел [_Медиафайлы->Библиотека_](/wordpress/wp-admin/upload.php) изображение и пометив его категорией _Для страниц языков_ — или заменив уже существующий файл иконки на другой при помощи ссылки _Заменить_ под нужной иконкой в списке изображений.

> Новые языки добавляются в основное меню сайта автоматически.

#Преподаватели

Преподаватели добавляются независимо от языков в соответствующем разделе админки. На странице всех преподавателей на сайте преподаватели сортируются по времени обновления информации. На странице преподавателя в админке можно:

- изменить имя (название) преподавателя, краткую информацию о нем (соответствующий блок);
- изменить биографию и краткое описание образования преподавателя — блок _Информация о преподавателе_ (на сайте — «О себе»). Текст до раскрывающей полный вид биографии ссылки («Подробнее») следует писать до тега _Далее (More)_;
- привязать к преподавателю занесенный в админку язык  — в правой колонке, блок _Связанные языки_;
- добавить фото преподавателя — правая колонка, соответствующий блок.

Фраза-call to action, отображаемая под фото преподавателя, редактируется на странице языка, к которому привязан преподаватель.

#Меню, виджеты и настройки сайта 

##Меню 

Сайт имеет два навигационных меню — основное («Языки», «Школа»...) и меню соцсетей, которое отображается в подвале сайта и на странице _Контакты_. Оба в админке редактируются в разделе [Внешний вид->Меню](/wordpress/wp-admin/nav-menus.php). Выбор меню производится при помощи выпадающего меню _Выберите меню для изменения_ наверху. Ссылки в меню добавляются из левой колонки страницы в правую путем активации флажка и нажатия кнопки _Добавить в меню_. Возможно создание подменю — для этого нужно в правой колонке сдвинуть мышкой вправо нужные пункты. По завершении работы с меню следует нажать кнопку вверху справа _Сохранить меню_. Количество пунктов меню на первом уровне всегда должно составлять 4, на втором — может быть любым.

> Добавлять в меню соцсетей новые пункты без контакта с дизайнером и разработчиком нежелательно. Это не касается редактирования или удаления уже существующих ссылок. Названия (поле _Текст ссылки_) на сайте не отображаются, поэтому могут быть любыми.

##Виджеты

Различные дополнительные текстовые данные, присутствующие на сайте, редактируются в разделе админки _Внешний вид->Виджеты_. В частности, здесь можно отредактировать:

- в блоке _Текст вверху шапки_ — телефон и e-mail, отображаемые в шапке всех страниц сайта. Можно добавлять и новые текстовые виджеты, выбрав в левой колонке блок _Текст_ и нажав кнопку _Добавить виджет_;
- в блоке _Блок для виджета рассылки в подвале_ — текст вверху формы рассылки в подвале. Другие настройки формы рассылки можно изменить в разделе админки [Mailchimp for WP](/wordpress/wp-admin/admin.php?page=mailchimp-for-wp);
- в блоке _Блок контактов в подвале_ — текст контактов в подвале. Можно использовать HTML-теги;
- в блоке _Подробнее о системе обучения в Linguamore_ - текст в соответствующей секции страницы «Преимущества» (см. выше).

> Электронные адреса, прописанные в виджетах и других местах админки, будут автоматически защищены от спам-ботов.

##Настройки

Основные (системные) настройки сайта находятся в разделе [Настройки](/wordpress/wp-admin/options-general.php). В частности, здесь можно изменить название и краткое описание сайта (подраздел [Общие](/wordpress/wp-admin/options-general.php)), количество записей на страницах списков записей (подраздел [Чтение](/wordpress/wp-admin/options-reading.php), поле _На страницах блога отображать не более_). Дополнительные настройки сайта находятся в разделе админки [Внешний вид->Настроить](/wordpress/wp-admin/customize.php), блок _Дополнительные настройки_. Здесь можно изменить текст по умолчанию (на русском языке), отображаемый под фото преподавателя. 


