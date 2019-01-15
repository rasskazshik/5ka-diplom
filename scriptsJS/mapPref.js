function init() {
    //берем координаты красной площади для инициализации карты
    //отключаем уведомления о старом браузере, интерактивность POI и ссылку на просмотр на Яндекс.Картах
    var myMap = new ymaps.Map('map', {
    center: [51.72989604173592,36.1926463300233],
    zoom: 11,
    controls: []
    },
    { 
    suppressObsoleteBrowserNotifier:true, 
    yandexMapDisablePoiInteractivity: true, 
    suppressMapOpenBlock: true
    });
    
    // Создадим экземпляр элемента управления «поиск по карте»
    // с установленной опцией провайдера данных для поиска по организациям.
    // отключим видимость этого контрола
    var searchControl = new ymaps.control.SearchControl({
        options: {
            provider: 'yandex#search',
            visible:false
        }
    });
    
    //добавляем контрол на карту
    myMap.controls.add(searchControl);
    
    // Программно выполним поиск всех Пятерочек в Курске
    // прямоугольной области карты.
    searchControl.search('курск пятерочка');
    //добавим одработчик события завершения поиска
    searchControl.events.add("load",function(){
        //получаем массив маркеров объектов
        var placemarks = searchControl.getResultsArray();
        //навешиваем свой обработчик нажатия на маркер
        placemarks.forEach(function(item) {
            //клик для каждого маркера
            item.events.add("click",function(e){
                //отключение базовой обработки события
                e.preventDefault();
                //получение информации о маркере
                //в дальнейшем отправка в серверный скрипт для выборки объекта комментариев 
                let address=item.properties._data.categoriesText+" "+item.properties._data.name+" "+item.properties._data.address;
                $.post("scriptsPHP/feedbacks/getFeedbacks.php",{address:address},function(feedbacks){
                    $(".feedbackContainer").slideToggle(500,function(){
                        $(".feedbackContainer").html(feedbacks);
                        $(".feedbackContainer").slideToggle(500);
                    });
                });
            });
        });
    });
}