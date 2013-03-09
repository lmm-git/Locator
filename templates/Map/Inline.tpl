{if empty($rand)}
	{LocatorRandom assign='rand'}
{/if}
{pageaddvarblock}
	<!--Locator map {$rand} -->
	{include file='Map/RawHead.tpl'}
	<!--End Locator map {$rand} -->
{/pageaddvarblock}
{include file='Map/RawBody.tpl'}
