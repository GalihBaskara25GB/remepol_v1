@include($pageProperties['htmlDir'].'.'.$pageProperties['pageHeader'])

<!-- Load HTML Components -->
@include($pageProperties['htmlUtilityDir'].'.modal')
@include($pageProperties['htmlUtilityDir'].'.loader')

@include($pageProperties['htmlDir'].'.'.$pageProperties['currentPage'])
@include($pageProperties['htmlDir'].'.'.$pageProperties['pageFooter'])