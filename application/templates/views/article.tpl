{if !$article}
	<p class="warning">
		Nie znaleziono artykułu o podanym id
	</p>
	<p>
		<a href="/" title="Wróc do strony głównej">&laquo; wróc do strony głównej</a>
	</p>
{else}
	<h2>{$article->title|escape}</h2>
	<strong>{$article->create_date|date_format:'%e-%m-%Y godz. %H:%M'}</strong>
	{if is_array($article->categories) && !empty($article->categories)}
		 &bull;
		 {foreach from=$article->categories item=category name=list_categories}
			{$category.name} {if !$smarty.foreach.list_categories.last},{/if}			
		 {/foreach}
	{/if}
	
	<hr />
	<p>
		{$article->content|escape|nl2br}
	</p>
	<hr />
	<p>
		Artykuł napisał <em>{$article->author_name}</em>
	</p>
{/if}