<ul>
            	<li>
                	<h3>栏目导航<span></span></h3>
                    <ol class="block">
                        <li {if $CHID == 0}class="select"{/if}>
                            <a href="/">首页</a>
                            <span></span>
                        </li>
                        {section name=i loop=$channels}
                    	<li {if $channels[i].CHID == $CHID}class="select"{/if}>
                        	<a href="{surl url=video/index/cid id=$channels[i].CHID}">{$channels[i].name}</a>
                            <span>{$channels[i].total_videos}</span>
                        </li>
                        {/section}
                    </ol>
                </li>
            </ul>
            <div><a href="http://cy.sougaga.com/yzmw/" target="_blank">加入赚钱计划</a></div>
            <div class="div1"><a href="http://cy.sougaga.com/yechajian/" target="_blank">站长采集插件</a></div>
            <div><a href="http://www.tt8.online/app/2118121.apk" target="_blank">点击下载安卓APP</a></div>
            <!--<div class="div2"><a href="">推广赚金币</a></div>-->
