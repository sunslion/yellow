{section name=i loop=$suggestVideo}
    <li>
        <p>
            <img class="lazy" data-original="{$suggestVideo[i].pic}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$suggestVideo[i].title}" title="{$suggestVideo[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
            <a href="{surl url=video/show/id id=$suggestVideo[i].VID}"></a>
        </p>
        <p>{$suggestVideo[i].title}</p>
        <p>
            <i>{$suggestVideo[i].addtime}</i>
            <strong>{$suggestVideo[i].viewnumber}观看</strong>
        </p>
    </li>
{/section}