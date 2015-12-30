angular.module("wfLibTemplates", []).run(["$templateCache", function($templateCache) {$templateCache.put("template/accordion/accordion-group.html","<div class=\"panel {{panelClass || \'panel-default\'}}\">\n  <div class=\"panel-heading\" ng-keypress=\"toggleOpen($event)\">\n    <h4 class=\"panel-title\">\n      <a href tabindex=\"0\" class=\"accordion-toggle\" ng-click=\"toggleOpen()\" uib-accordion-transclude=\"heading\"><span ng-class=\"{\'text-muted\': isDisabled}\">{{heading}}</span></a>\n    </h4>\n  </div>\n  <div class=\"panel-collapse collapse\" uib-collapse=\"!isOpen\">\n	  <div class=\"panel-body\" ng-transclude></div>\n  </div>\n</div>\n");
$templateCache.put("template/accordion/accordion.html","<div class=\"panel-group\" ng-transclude></div>");
$templateCache.put("template/alert/alert.html","<div class=\"alert\" ng-class=\"[\'alert-\' + (type || \'warning\'), closeable ? \'alert-dismissible\' : null]\" role=\"alert\">\n    <button ng-show=\"closeable\" type=\"button\" class=\"close\" ng-click=\"close({$event: $event})\">\n        <span aria-hidden=\"true\">&times;</span>\n        <span class=\"sr-only\">Close</span>\n    </button>\n    <div ng-transclude></div>\n</div>\n");
$templateCache.put("template/carousel/carousel.html","<div ng-mouseenter=\"pause()\" ng-mouseleave=\"play()\" class=\"carousel\" ng-swipe-right=\"prev()\" ng-swipe-left=\"next()\">\n  <div class=\"carousel-inner\" ng-transclude></div>\n  <a role=\"button\" href class=\"left carousel-control\" ng-click=\"prev()\" ng-show=\"slides.length > 1\">\n    <span aria-hidden=\"true\" class=\"glyphicon glyphicon-chevron-left\"></span>\n    <span class=\"sr-only\">previous</span>\n  </a>\n  <a role=\"button\" href class=\"right carousel-control\" ng-click=\"next()\" ng-show=\"slides.length > 1\">\n    <span aria-hidden=\"true\" class=\"glyphicon glyphicon-chevron-right\"></span>\n    <span class=\"sr-only\">next</span>\n  </a>\n  <ol class=\"carousel-indicators\" ng-show=\"slides.length > 1\">\n    <li ng-repeat=\"slide in slides | orderBy:indexOfSlide track by $index\" ng-class=\"{ active: isActive(slide) }\" ng-click=\"select(slide)\">\n      <span class=\"sr-only\">slide {{ $index + 1 }} of {{ slides.length }}<span ng-if=\"isActive(slide)\">, currently active</span></span>\n    </li>\n  </ol>\n</div>");
$templateCache.put("template/carousel/slide.html","<div ng-class=\"{\n    \'active\': active\n  }\" class=\"item text-center\" ng-transclude></div>\n");
$templateCache.put("template/modal/backdrop.html","<div uib-modal-animation-class=\"fade\"\n     modal-in-class=\"in\"\n     ng-style=\"{\'z-index\': 1040 + (index && 1 || 0) + index*10}\"\n></div>\n");
$templateCache.put("template/modal/window.html","<div modal-render=\"{{$isRendered}}\" tabindex=\"-1\" role=\"dialog\" class=\"modal\"\n    uib-modal-animation-class=\"fade\"\n    modal-in-class=\"in\"\n    ng-style=\"{\'z-index\': 1050 + index*10, display: \'block\'}\">\n    <div class=\"modal-dialog\" ng-class=\"size ? \'modal-\' + size : \'\'\"><div class=\"modal-content\" uib-modal-transclude></div></div>\n</div>\n");
$templateCache.put("template/datepicker/datepicker.html","<div ng-switch=\"datepickerMode\" role=\"application\" ng-keydown=\"keydown($event)\">\n  <uib-daypicker ng-switch-when=\"day\" tabindex=\"0\"></uib-daypicker>\n  <uib-monthpicker ng-switch-when=\"month\" tabindex=\"0\"></uib-monthpicker>\n  <uib-yearpicker ng-switch-when=\"year\" tabindex=\"0\"></uib-yearpicker>\n</div>");
$templateCache.put("template/datepicker/day.html","<table role=\"grid\" aria-labelledby=\"{{::uniqueId}}-title\" aria-activedescendant=\"{{activeDateId}}\">\n  <thead>\n    <tr>\n      <th><button type=\"button\" class=\"btn btn-default btn-sm pull-left\" ng-click=\"move(-1)\" tabindex=\"-1\"><i class=\"glyphicon glyphicon-chevron-left\"></i></button></th>\n      <th colspan=\"{{::5 + showWeeks}}\"><button id=\"{{::uniqueId}}-title\" role=\"heading\" aria-live=\"assertive\" aria-atomic=\"true\" type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"toggleMode()\" ng-disabled=\"datepickerMode === maxMode\" tabindex=\"-1\" style=\"width:100%;\"><strong>{{title}}</strong></button></th>\n      <th><button type=\"button\" class=\"btn btn-default btn-sm pull-right\" ng-click=\"move(1)\" tabindex=\"-1\"><i class=\"glyphicon glyphicon-chevron-right\"></i></button></th>\n    </tr>\n    <tr>\n      <th ng-if=\"showWeeks\" class=\"text-center\"></th>\n      <th ng-repeat=\"label in ::labels track by $index\" class=\"text-center\"><small aria-label=\"{{::label.full}}\">{{::label.abbr}}</small></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr ng-repeat=\"row in rows track by $index\">\n      <td ng-if=\"showWeeks\" class=\"text-center h6\"><em>{{ weekNumbers[$index] }}</em></td>\n      <td ng-repeat=\"dt in row track by dt.date\" class=\"text-center\" role=\"gridcell\" id=\"{{::dt.uid}}\" ng-class=\"::dt.customClass\">\n        <button type=\"button\" style=\"min-width:100%;\" class=\"btn btn-default btn-sm\" ng-class=\"{\'btn-info\': dt.selected, active: isActive(dt)}\" ng-click=\"select(dt.date)\" ng-disabled=\"dt.disabled\" tabindex=\"-1\"><span ng-class=\"::{\'text-muted\': dt.secondary, \'text-info\': dt.current}\">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n");
$templateCache.put("template/datepicker/month.html","<table role=\"grid\" aria-labelledby=\"{{::uniqueId}}-title\" aria-activedescendant=\"{{activeDateId}}\">\n  <thead>\n    <tr>\n      <th><button type=\"button\" class=\"btn btn-default btn-sm pull-left\" ng-click=\"move(-1)\" tabindex=\"-1\"><i class=\"glyphicon glyphicon-chevron-left\"></i></button></th>\n      <th><button id=\"{{::uniqueId}}-title\" role=\"heading\" aria-live=\"assertive\" aria-atomic=\"true\" type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"toggleMode()\" ng-disabled=\"datepickerMode === maxMode\" tabindex=\"-1\" style=\"width:100%;\"><strong>{{title}}</strong></button></th>\n      <th><button type=\"button\" class=\"btn btn-default btn-sm pull-right\" ng-click=\"move(1)\" tabindex=\"-1\"><i class=\"glyphicon glyphicon-chevron-right\"></i></button></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr ng-repeat=\"row in rows track by $index\">\n      <td ng-repeat=\"dt in row track by dt.date\" class=\"text-center\" role=\"gridcell\" id=\"{{::dt.uid}}\" ng-class=\"::dt.customClass\">\n        <button type=\"button\" style=\"min-width:100%;\" class=\"btn btn-default\" ng-class=\"{\'btn-info\': dt.selected, active: isActive(dt)}\" ng-click=\"select(dt.date)\" ng-disabled=\"dt.disabled\" tabindex=\"-1\"><span ng-class=\"::{\'text-info\': dt.current}\">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n");
$templateCache.put("template/datepicker/popup.html","<ul class=\"dropdown-menu\" dropdown-nested ng-if=\"isOpen\" style=\"display: block\" ng-style=\"{top: position.top+\'px\', left: position.left+\'px\'}\" ng-keydown=\"keydown($event)\" ng-click=\"$event.stopPropagation()\">\n	<li ng-transclude></li>\n	<li ng-if=\"showButtonBar\" style=\"padding:10px 9px 2px\">\n		<span class=\"btn-group pull-left\">\n			<button type=\"button\" class=\"btn btn-sm btn-info\" ng-click=\"select(\'today\')\" ng-disabled=\"isDisabled(\'today\')\">{{ getText(\'current\') }}</button>\n			<button type=\"button\" class=\"btn btn-sm btn-danger\" ng-click=\"select(null)\">{{ getText(\'clear\') }}</button>\n		</span>\n		<button type=\"button\" class=\"btn btn-sm btn-success pull-right\" ng-click=\"close()\">{{ getText(\'close\') }}</button>\n	</li>\n</ul>\n");
$templateCache.put("template/datepicker/year.html","<table role=\"grid\" aria-labelledby=\"{{::uniqueId}}-title\" aria-activedescendant=\"{{activeDateId}}\">\n  <thead>\n    <tr>\n      <th><button type=\"button\" class=\"btn btn-default btn-sm pull-left\" ng-click=\"move(-1)\" tabindex=\"-1\"><i class=\"glyphicon glyphicon-chevron-left\"></i></button></th>\n      <th colspan=\"3\"><button id=\"{{::uniqueId}}-title\" role=\"heading\" aria-live=\"assertive\" aria-atomic=\"true\" type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"toggleMode()\" ng-disabled=\"datepickerMode === maxMode\" tabindex=\"-1\" style=\"width:100%;\"><strong>{{title}}</strong></button></th>\n      <th><button type=\"button\" class=\"btn btn-default btn-sm pull-right\" ng-click=\"move(1)\" tabindex=\"-1\"><i class=\"glyphicon glyphicon-chevron-right\"></i></button></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr ng-repeat=\"row in rows track by $index\">\n      <td ng-repeat=\"dt in row track by dt.date\" class=\"text-center\" role=\"gridcell\" id=\"{{::dt.uid}}\" ng-class=\"::dt.customClass\">\n        <button type=\"button\" style=\"min-width:100%;\" class=\"btn btn-default\" ng-class=\"{\'btn-info\': dt.selected, active: isActive(dt)}\" ng-click=\"select(dt.date)\" ng-disabled=\"dt.disabled\" tabindex=\"-1\"><span ng-class=\"::{\'text-info\': dt.current}\">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n");
$templateCache.put("template/pagination/pager.html","<ul class=\"pager\">\n  <li ng-class=\"{disabled: noPrevious()||ngDisabled, previous: align}\"><a href ng-click=\"selectPage(page - 1, $event)\">{{::getText(\'previous\')}}</a></li>\n  <li ng-class=\"{disabled: noNext()||ngDisabled, next: align}\"><a href ng-click=\"selectPage(page + 1, $event)\">{{::getText(\'next\')}}</a></li>\n</ul>\n");
$templateCache.put("template/pagination/pagination.html","<ul class=\"pagination\">\n  <li ng-if=\"::boundaryLinks\" ng-class=\"{disabled: noPrevious()||ngDisabled}\" class=\"pagination-first\"><a href ng-click=\"selectPage(1, $event)\">{{::getText(\'first\')}}</a></li>\n  <li ng-if=\"::directionLinks\" ng-class=\"{disabled: noPrevious()||ngDisabled}\" class=\"pagination-prev\"><a href ng-click=\"selectPage(page - 1, $event)\">{{::getText(\'previous\')}}</a></li>\n  <li ng-repeat=\"page in pages track by $index\" ng-class=\"{active: page.active,disabled: ngDisabled&&!page.active}\" class=\"pagination-page\"><a href ng-click=\"selectPage(page.number, $event)\">{{page.text}}</a></li>\n  <li ng-if=\"::directionLinks\" ng-class=\"{disabled: noNext()||ngDisabled}\" class=\"pagination-next\"><a href ng-click=\"selectPage(page + 1, $event)\">{{::getText(\'next\')}}</a></li>\n  <li ng-if=\"::boundaryLinks\" ng-class=\"{disabled: noNext()||ngDisabled}\" class=\"pagination-last\"><a href ng-click=\"selectPage(totalPages, $event)\">{{::getText(\'last\')}}</a></li>\n</ul>\n");
$templateCache.put("template/popover/popover-html.html","<div tooltip-animation-class=\"fade\"\n  uib-tooltip-classes\n  ng-class=\"{ in: isOpen() }\">\n  <div class=\"arrow\"></div>\n\n  <div class=\"popover-inner\">\n      <h3 class=\"popover-title\" ng-bind=\"title\" ng-if=\"title\"></h3>\n      <div class=\"popover-content\" ng-bind-html=\"contentExp()\"></div>\n  </div>\n</div>\n");
$templateCache.put("template/popover/popover-template.html","<div tooltip-animation-class=\"fade\"\n  uib-tooltip-classes\n  ng-class=\"{ in: isOpen() }\">\n  <div class=\"arrow\"></div>\n\n  <div class=\"popover-inner\">\n      <h3 class=\"popover-title\" ng-bind=\"title\" ng-if=\"title\"></h3>\n      <div class=\"popover-content\"\n        uib-tooltip-template-transclude=\"contentExp()\"\n        tooltip-template-transclude-scope=\"originScope()\"></div>\n  </div>\n</div>\n");
$templateCache.put("template/popover/popover.html","<div tooltip-animation-class=\"fade\"\n  uib-tooltip-classes\n  ng-class=\"{ in: isOpen() }\">\n  <div class=\"arrow\"></div>\n\n  <div class=\"popover-inner\">\n      <h3 class=\"popover-title\" ng-bind=\"title\" ng-if=\"title\"></h3>\n      <div class=\"popover-content\" ng-bind=\"content\"></div>\n  </div>\n</div>\n");
$templateCache.put("template/progressbar/bar.html","<div class=\"progress-bar\" ng-class=\"type && \'progress-bar-\' + type\" role=\"progressbar\" aria-valuenow=\"{{value}}\" aria-valuemin=\"0\" aria-valuemax=\"{{max}}\" ng-style=\"{width: (percent < 100 ? percent : 100) + \'%\'}\" aria-valuetext=\"{{percent | number:0}}%\" aria-labelledby=\"{{::title}}\" style=\"min-width: 0;\" ng-transclude></div>\n");
$templateCache.put("template/progressbar/progress.html","<div class=\"progress\" ng-transclude aria-labelledby=\"{{::title}}\"></div>");
$templateCache.put("template/progressbar/progressbar.html","<div class=\"progress\">\n  <div class=\"progress-bar\" ng-class=\"type && \'progress-bar-\' + type\" role=\"progressbar\" aria-valuenow=\"{{value}}\" aria-valuemin=\"0\" aria-valuemax=\"{{max}}\" ng-style=\"{width: (percent < 100 ? percent : 100) + \'%\'}\" aria-valuetext=\"{{percent | number:0}}%\" aria-labelledby=\"{{::title}}\" style=\"min-width: 0;\" ng-transclude></div>\n</div>\n");
$templateCache.put("template/rating/rating.html","<span ng-mouseleave=\"reset()\" ng-keydown=\"onKeydown($event)\" tabindex=\"0\" role=\"slider\" aria-valuemin=\"0\" aria-valuemax=\"{{range.length}}\" aria-valuenow=\"{{value}}\">\n    <span ng-repeat-start=\"r in range track by $index\" class=\"sr-only\">({{ $index < value ? \'*\' : \' \' }})</span>\n    <i ng-repeat-end ng-mouseenter=\"enter($index + 1)\" ng-click=\"rate($index + 1)\" class=\"glyphicon\" ng-class=\"$index < value && (r.stateOn || \'glyphicon-star\') || (r.stateOff || \'glyphicon-star-empty\')\" ng-attr-title=\"{{r.title}}\" aria-valuetext=\"{{r.title}}\"></i>\n</span>\n");
$templateCache.put("template/tabs/tab.html","<li ng-class=\"{active: active, disabled: disabled}\">\n  <a href ng-click=\"select()\" uib-tab-heading-transclude>{{heading}}</a>\n</li>\n");
$templateCache.put("template/tabs/tabset.html","<div>\n  <ul class=\"nav nav-{{type || \'tabs\'}}\" ng-class=\"{\'nav-stacked\': vertical, \'nav-justified\': justified}\" ng-transclude></ul>\n  <div class=\"tab-content\">\n    <div class=\"tab-pane\" \n         ng-repeat=\"tab in tabs\" \n         ng-class=\"{active: tab.active}\"\n         uib-tab-content-transclude=\"tab\">\n    </div>\n  </div>\n</div>\n");
$templateCache.put("template/tooltip/tooltip-html-popup.html","<div\n  tooltip-animation-class=\"fade\"\n  uib-tooltip-classes\n  ng-class=\"{ in: isOpen() }\">\n  <div class=\"tooltip-arrow\"></div>\n  <div class=\"tooltip-inner\" ng-bind-html=\"contentExp()\"></div>\n</div>\n");
$templateCache.put("template/tooltip/tooltip-popup.html","<div\n  tooltip-animation-class=\"fade\"\n  uib-tooltip-classes\n  ng-class=\"{ in: isOpen() }\">\n  <div class=\"tooltip-arrow\"></div>\n  <div class=\"tooltip-inner\" ng-bind=\"content\"></div>\n</div>\n");
$templateCache.put("template/tooltip/tooltip-template-popup.html","<div\n  tooltip-animation-class=\"fade\"\n  uib-tooltip-classes\n  ng-class=\"{ in: isOpen() }\">\n  <div class=\"tooltip-arrow\"></div>\n  <div class=\"tooltip-inner\"\n    uib-tooltip-template-transclude=\"contentExp()\"\n    tooltip-template-transclude-scope=\"originScope()\"></div>\n</div>\n");
$templateCache.put("template/timepicker/timepicker.html","<table>\n  <tbody>\n    <tr class=\"text-center\" ng-show=\"::showSpinners\">\n      <td><a ng-click=\"incrementHours()\" ng-class=\"{disabled: noIncrementHours()}\" class=\"btn btn-link\" ng-disabled=\"noIncrementHours()\" tabindex=\"{{::tabindex}}\"><span class=\"glyphicon glyphicon-chevron-up\"></span></a></td>\n      <td>&nbsp;</td>\n      <td><a ng-click=\"incrementMinutes()\" ng-class=\"{disabled: noIncrementMinutes()}\" class=\"btn btn-link\" ng-disabled=\"noIncrementMinutes()\" tabindex=\"{{::tabindex}}\"><span class=\"glyphicon glyphicon-chevron-up\"></span></a></td>\n      <td ng-show=\"showMeridian\"></td>\n    </tr>\n    <tr>\n      <td class=\"form-group\" ng-class=\"{\'has-error\': invalidHours}\">\n        <input style=\"width:50px;\" type=\"text\" ng-model=\"hours\" ng-change=\"updateHours()\" class=\"form-control text-center\" ng-readonly=\"::readonlyInput\" maxlength=\"2\" tabindex=\"{{::tabindex}}\">\n      </td>\n      <td>:</td>\n      <td class=\"form-group\" ng-class=\"{\'has-error\': invalidMinutes}\">\n        <input style=\"width:50px;\" type=\"text\" ng-model=\"minutes\" ng-change=\"updateMinutes()\" class=\"form-control text-center\" ng-readonly=\"::readonlyInput\" maxlength=\"2\" tabindex=\"{{::tabindex}}\">\n      </td>\n      <td ng-show=\"showMeridian\"><button type=\"button\" ng-class=\"{disabled: noToggleMeridian()}\" class=\"btn btn-default text-center\" ng-click=\"toggleMeridian()\" ng-disabled=\"noToggleMeridian()\" tabindex=\"{{::tabindex}}\">{{meridian}}</button></td>\n    </tr>\n    <tr class=\"text-center\" ng-show=\"::showSpinners\">\n      <td><a ng-click=\"decrementHours()\" ng-class=\"{disabled: noDecrementHours()}\" class=\"btn btn-link\" ng-disabled=\"noDecrementHours()\" tabindex=\"{{::tabindex}}\"><span class=\"glyphicon glyphicon-chevron-down\"></span></a></td>\n      <td>&nbsp;</td>\n      <td><a ng-click=\"decrementMinutes()\" ng-class=\"{disabled: noDecrementMinutes()}\" class=\"btn btn-link\" ng-disabled=\"noDecrementMinutes()\" tabindex=\"{{::tabindex}}\"><span class=\"glyphicon glyphicon-chevron-down\"></span></a></td>\n      <td ng-show=\"showMeridian\"></td>\n    </tr>\n  </tbody>\n</table>\n");
$templateCache.put("template/typeahead/typeahead-match.html","<a href tabindex=\"-1\" ng-bind-html=\"match.label | uibTypeaheadHighlight:query\"></a>\n");
$templateCache.put("template/typeahead/typeahead-popup.html","<ul class=\"dropdown-menu\" ng-show=\"isOpen() && !moveInProgress\" ng-style=\"{top: position().top+\'px\', left: position().left+\'px\'}\" style=\"display: block;\" role=\"listbox\" aria-hidden=\"{{!isOpen()}}\">\n    <li ng-repeat=\"match in matches track by $index\" ng-class=\"{active: isActive($index) }\" ng-mouseenter=\"selectActive($index)\" ng-click=\"selectMatch($index)\" role=\"option\" id=\"{{::match.id}}\">\n        <div uib-typeahead-match index=\"$index\" match=\"match\" query=\"query\" template-url=\"templateUrl\"></div>\n    </li>\n</ul>\n");}]);