/* Russian initialisation for the jQuery time picker plugin. */
/* Writen by Zakhar Day (zakhar.day@gmail.com) */
jQuery(function($){
    $.timepicker.regional['ru'] = {
                hourText: 'Часы',
                minuteText: 'Минуты',
                 secondText: 'Секунды',
                amPmText: ['AM', 'PM'],
                closeButtonText: 'Готово',
                nowButtonText: 'Сейчас',
                timeOnlyTitle: 'Выберите время',
              currentText: 'Сейчас',
              closeText: 'Готово',
                deselectButtonText: 'Снять выделение' }
    $.timepicker.setDefaults($.timepicker.regional['ru']);
});
