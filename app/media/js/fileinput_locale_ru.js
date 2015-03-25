/*!
 * FileInput <language> Translations - Template file for copying and creating other translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinput.locales.ru = {
        fileSingle: 'файл',
        filePlural: 'файлы',
        browseLabel: 'Просмотр &hellip;',
        removeLabel: 'Удалить',
        removeTitle: 'Очистить выделеные файлы',
        cancelLabel: 'Отмена',
        cancelTitle: 'Прервать текущую загрузку',
        uploadLabel: 'Загрузить',
        uploadTitle: 'Загрузить выбранные файлы',
        msgSizeTooLarge: 'Файл "{name}" (<b>{size} KB</b>) превышает максимально допустимый размер <b>{maxSize} KB</b>. Пожалуйста, повторите загрузку!',
        msgFilesTooLess: 'Вы должны выбрать по крайней мере <b>{n}</b> {files} для загрузки. Пожалуйста, повторите загрузку!',
        msgFilesTooMany: 'Количество файлов, выбранных для загрузки <b>({n})</b> превышает максимально допустимый предел в <b>{m}</b>. Пожалуйста, повторите загрузку!',
        msgFileNotFound: 'Файл "{name}" не найден!',
        msgFileSecured: 'Security restrictions prevent reading the file "{name}".',
        msgFileNotReadable: 'File "{name}" is not readable.',
        msgFilePreviewAborted: 'File preview aborted for "{name}".',
        msgFilePreviewError: 'An error occurred while reading the file "{name}".',
        msgInvalidFileType: 'Invalid type for file "{name}". Only "{types}" files are supported.',
        msgInvalidFileExtension: 'Invalid extension for file "{name}". Only "{extensions}" files are supported.',
        msgValidationError: 'File Upload Error',
        msgLoading: 'Loading file {index} of {files} &hellip;',
        msgProgress: 'Loading file {index} of {files} - {name} - {percent}% completed.',
        msgSelected: '{n} files selected',
        msgFoldersNotAllowed: 'Drag & drop files only! Skipped {n} dropped folder(s).',
        dropZoneTitle: 'Drag & drop files here &hellip;'
    };

    $.extend($.fn.fileinput.defaults, $.fn.fileinput.locales.ru);
})(window.jQuery);