<?php
$this->breadcrumbs=array(
	'Search'=>array('index'),
);

$this->stockMenus(array());

?>

<?php $this->renderPartial('_search', array( 'query'=>$query ) ); ?>

<?php
$totalResults = count( $results );
if ( $query && ! $totalResults )
{
	echo '<h3>No results found for <strong>' . $query . '</strong>.</h3>';
}
if ( $totalResults )
{
	$totalCount = count( $results );
	echo '<h3>Found ' . $totalCount . ' results for <strong>' . $query . '</strong>.</h3>';
	$countMessages = array();
	foreach ( $resultInfo as $type => $count )
	{
		if ( $count == 0 )
		{
			continue;
		}
		$countMessages[] = $count . ' ' . $type . ( $count == 1 ? '' : 's' );
	}
	echo '<p>( ' . implode( ', ', $countMessages ) . ' )</p>';
}
foreach ( $results as $key=> $model )
{

	if ( ! $model )
	{
		continue;
	}
	elseif ( $model instanceof Originator )
	{
		$view = '//originator/_summarySubPanel';
	}
	elseif ( $model instanceof OriginatorInfo )
	{
		$view = '//originatorInfo/_summarySubPanel';
	}
	elseif ( $model instanceof PaymentProfile )
	{
		$view = '//paymentProfile/_summarySubPanel';
	}
	elseif ( $model instanceof AchEntry )
	{
		$view = '//achEntry/_summarySubPanel';
	}
	else
	{
		continue;
	}
	
	$this->renderPartial($view, array( 'model'=>$model ) );
}


?>
