@extends('layouts.app')

@section('title', 'Политика конфиденциальности')
@section('seo_description', 'Полные условия обработки и защиты персональных данных. Ваша информация находится в сохранности.')
@section('og_title', 'Политика конфиденциальности - Svoy Master')
@section('og_description', 'Полные условия обработки и защиты ваших персональных данных')
@section('og_image', asset('images/logo.png'))

@section('content')
    <x-breadcrumbs :links="['' => 'Политика конфиденциальности']" />

    <section class="page-container catalog-page">
        <div class="catalog-card space-y-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1A1A1A]">Политика конфиденциальности</h1>
            
            <p class="text-gray-600 leading-relaxed text-sm text-gray-500">
                Дата последнего обновления: {{ now()->format('d.m.Y') }}
            </p>

            <div class="prose-content space-y-6">
                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">1. Общие положения</h2>
                    <p class="text-gray-600 leading-relaxed">
                        ИП Егоров Олег Валерьевич (далее – «Компания», «мы», «нас») гарантирует защиту и соблюдение конфиденциальности персональных данных пользователей сайта <strong>svoymaster96.ru</strong> (далее – «Сайт»). 
                        Настоящая политика конфиденциальности описывает способы сбора, использования, обработки и защиты информации, которую мы получаем от посетителей нашего Сайта.
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-3">
                        Используя Сайт, вы соглашаетесь с условиями настоящей политики конфиденциальности. Если вы не согласны со способом обработки вашей информации, просим вас воздержаться от использования Сайта.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">2. Какую информацию мы собираем</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">Мы собираем следующие типы информации:</p>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">2.1 Информация, которую вы предоставляете добровольно:</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 mb-4">
                        <li><strong>При заполнении форм контакта:</strong> ФИО, номер телефона, адрес электронной почты, комментарии о проблеме с устройством</li>
                        <li><strong>При размещении заявок на ремонт:</strong> информация об устройстве, описание дефекта, место нахождения</li>
                        <li><strong>При обратной связи:</strong> любая информация, которую вы добровольно отправляете через контактные формы</li>
                    </ul>

                    <h3 class="text-lg font-semibold text-gray-800 mb-2">2.2 Информация, собираемая автоматически:</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                        <li><strong>Данные о доступе:</strong> IP-адрес, тип браузера, операционная система, страницы, которые вы посещали</li>
                        <li><strong>Cookie файлы:</strong> для аналитики, персонализации и улучшения пользовательского опыта</li>
                        <li><strong>UTM-параметры:</strong> источник трафика, тип кампании (utm_source, utm_campaign, utm_medium и т.д.)</li>
                        <li><strong>Реферер:</strong> адрес предыдущей страницы, с которой вы пришли на Сайт</li>
                        <li><strong>User-Agent:</strong> информация о устройстве и браузере для целей аналитики</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">3. Цели использования информации</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">Мы используем собираемую информацию в следующих целях:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                        <li>Обработка и выполнение ваших заявок на ремонт устройств</li>
                        <li>Позвонить вам для уточнения деталей заявки и согласования времени приёма</li>
                        <li>Отправка уведомлений о статусе ремонта вашего устройства</li>
                        <li>Улучшение качества услуг и пользовательского опыта на Сайте</li>
                        <li>Проведение аналитики трафика и поведения пользователей</li>
                        <li>Отправка информационных и маркетинговых сообщений (только с вашего согласия)</li>
                        <li>Выполнение требований законодательства и защита прав Компании</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">4. Период хранения данных</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Персональные данные обрабатываются в течение времени, необходимого для достижения целей их обработки. 
                        В стандартном случае информация хранится <strong>в течение одного года</strong> после последнего контакта, 
                        если в дальнейшем не требуется для выполнения договорных обязательств или соответствия законодательству 
                        Российской Федерации (включая налоговое законодательство).
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-3">
                        Информация об использовании Cookie хранится в соответствии с настройками браузера и законодательству 
                        об электронной коммерции.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">5. Защита персональных данных</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">
                        Мы принимаем необходимые и надлежащие меры для защиты персональных данных от неавторизованного доступа, 
                        изменения, раскрытия или уничтожения, включая:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                        <li>Использование защищённого протокола HTTPS для передачи данных</li>
                        <li>Ограничение доступа к личной информации только сотрудниками Компании, имеющими необходимость в таком доступе</li>
                        <li>Соблюдение требований законодательства о защите данных</li>
                        <li>Регулярную проверку систем безопасности</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4 text-sm bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <strong class="text-yellow-900">Важно:</strong> Несмотря на наши меры предосторожности, ни одна система безопасности не является абсолютно невредимой. 
                        Передача данных по интернету сопровождается определённым риском.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">6. Передача данных третьим лицам</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Мы <strong>не передаём</strong> ваши персональные данные третьим лицам без вашего явного согласия, 
                        за исключением случаев, когда это требуется:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 mt-3">
                        <li>Действующим законодательством Российской Федерации</li>
                        <li>Судебными или иными правоохранительными органами</li>
                        <li>Выполнением договорных обязательств (например, если услугу оказывает курьер или специалист)</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-3">
                        В случае передачи данных третьим лицам мы требуем от них соблюдения настоящей политики конфиденциальности.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">7. Cookie файлы</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">
                        Сайт использует Cookie файлы для улучшения функциональности и анализа трафика. Cookie – это небольшие файлы 
                        данных, сохраняемые на вашем устройстве браузером.
                    </p>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Типы используемых Cookie:</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                        <li><strong>Необходимые (Essential):</strong> для корректной работы Сайта</li>
                        <li><strong>Аналитические:</strong> для сбора информации об использовании Сайта (Яндекс.Метрика, Google Analytics)</li>
                        <li><strong>Функциональные:</strong> для запоминания ваших предпочтений</li>
                        <li><strong>Маркетинговые:</strong> для отслеживания рекламных кампаний</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        Вы можете управлять Cookie в настройках вашего браузера. Удаление Cookie может повлиять на функциональность Сайта.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">8. Реклама и аналитика</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Сайт использует сервисы аналитики и контекстной рекламы (Яндекс.Метрика, Google Analytics, Яндекс.Директ), 
                        которые собирают анонимизированные данные о поведении пользователей. Эти данные не содержат личной информации.
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-3">
                        Партнёры по рекламе могут использовать ваши данные (после анонимизации) для показа релевантной рекламы на других сайтах.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">9. Ваши права</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">В соответствии с действующим законодательством вы имеете право:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                        <li><strong>Запросить доступ</strong> к вашим персональным данным</li>
                        <li><strong>Требовать исправление</strong> неточных данных</li>
                        <li><strong>Требовать удаление</strong> вашей информации (при наличии законных оснований)</li>
                        <li><strong>Отозвать согласие</strong> на обработку данных в любой момент</li>
                        <li><strong>Получить информацию</strong> о том, как используются ваши данные</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        Для упражнения своих прав свяжитесь с нами по адресу: <a href="mailto:remont@svoymaster96.ru" class="text-[#0678A8] hover:text-[#2AC0D5] transition">remont@svoymaster96.ru</a>
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">10. Ссылки на другие сайты</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Сайт может содержать ссылки на другие веб-сайты. Мы не несём ответственность за политику конфиденциальности 
                        или содержание сторонних сайтов. Рекомендуем вам ознакомиться с политикой конфиденциальности любого сайта, 
                        перед тем как предоставлять ему персональные данные.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">11. Изменения политики</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Мы оставляем за собой право изменять настоящую политику конфиденциальности в любой момент. 
                        Если будут внесены существенные изменения, мы уведомим вас, разместив новую версию на Сайте 
                        с обновлённой датой. Продолжение использования Сайта означает ваше согласие с обновлённой политикой.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-[#1A1A1A] mb-3">12. Контакты</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">
                        Если у вас есть вопросы о настоящей политике конфиденциальности или о том, как мы обрабатываем ваши данные, 
                        пожалуйста, свяжитесь с нами:
                    </p>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-2">
                        <p class="text-gray-700"><strong>Email:</strong> <a href="mailto:remont@svoymaster96.ru" class="text-[#0678A8] hover:text-[#2AC0D5] transition">remont@svoymaster96.ru</a></p>
                        <p class="text-gray-700"><strong>Телефон:</strong> <a href="tel:+73432264622" class="text-[#0678A8] hover:text-[#2AC0D5] transition">+7 (343) 226-46-22</a></p>
                        <p class="text-gray-700"><strong>Адрес:</strong> г. Екатеринбург, ул. Антона Валека, 13, офис 200</p>
                        <p class="text-gray-700"><strong>ИНН:</strong> 661403702400</p>
                        <p class="text-gray-700"><strong>Организация:</strong> ИП Егоров Олег Валерьевич</p>
                    </div>
                </section>

                <section class="bg-blue-50 border-l-4 border-[#0678A8] p-4 rounded-r mt-6">
                    <p class="text-sm text-gray-700">
                        Используя Сайт, вы подтверждаете, что ознакомились и согласны с условиями настоящей политики конфиденциальности.
                    </p>
                </section>
            </div>
        </div>
    </section>
@endsection
