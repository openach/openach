<?php

class SearchController extends OAController
{
	protected function fuzzySearch()
	{
		Yii::import( 'application.vendors.OpenData.Phonetic.*' );
		$encodingAlgorithm = 'metaphone';

		$query = Yii::app()->request->getParam( 'query' );

		$searchCriteria = array(); // For keyword and phonetic search
		$entryCriteria = array(); // For ach entry search

		if ( $query )
		{
			$searchTerms = explode( ' ', $query );
			for ( $i = 0 ; $i < count( $searchTerms ); $i++ )
			{
				$searchTerm = $searchTerms[$i];
				$searchTerm = trim( $searchTerm );
				if ( ! $searchTerm )
				{
					continue;
				}
				else
				{
					// Use phonetic hashing on our search term
					$hashedTerm = ODPhonetic::encode( $searchTerm, $encodingAlgorithm );

					// Note that we fold in repeated terms to simplify the query
					$searchCriteria[] = $hashedTerm;

					if ( substr( $searchTerm, 0, 2 ) == 'OA' && strlen( $searchTerm ) > 2 )
					{
						$entryCriteria[] = substr( $searchTerm, 2 );
					}

				}
			}
		}

		$results = array();

		if ( $searchCriteria )
		{
			$classes = array( 'Originator', 'OriginatorInfo', 'PaymentProfile' );
			foreach ( $classes as $entity_class )
			{
			
				$criteria = new CDbCriteria();

				$criteria->addCondition( 'phonetic_data_entity_class = :entity_class' );
				$criteria->params = array( ':entity_class' => $entity_class );
				$criteria->addInCondition( 'phonetic_data_key', $searchCriteria );

				$primaryKey = $entity_class::model()->getMetaData()->tableSchema->primaryKey;
				$tableName = $entity_class::model()->tableName();
				if ( ! is_string( $primaryKey ) )
				{
					throw new Exception( 'Unable to search on sources with composite keys.' );
				}

				if ( ! $tableName )
				{
					throw new Exception( 'Unable to search on sources without a table name.' );
				}

				$criteria->join .= ' INNER JOIN ' . $entity_class::model()->tableName() . ' ON ( phonetic_data_entity_id = ' . $primaryKey . ' ) ';
				$entity_class::addUserJoin( $criteria );

				$criteria->limit = 20;

				$phoneticResults = PhoneticData::model()->findAll( $criteria );
				$resultCounts = array();
				$resultInfo = array( 'originator'=>0, 'origination account'=>0, 'payment profile'=>0, 'transaction'=>0 );

				foreach ( $phoneticResults as $phoneticData )
				{
					if ( isset( $resultCounts[ $phoneticData->phonetic_data_entity_id ] ) )
					{
						$resultCounts[ $phoneticData->phonetic_data_entity_id ]++;
					}
					else
					{
						$resultCounts[ $phoneticData->phonetic_data_entity_id ] = 1;
					}

					if (  $resultCounts[ $phoneticData->phonetic_data_entity_id ] >= count( $searchCriteria ) && ! isset( $results[ $phoneticData->phonetic_data_entity_id ] ) )
					{
						$modelClass = $phoneticData->phonetic_data_entity_class;
						$model = $modelClass::model()->findByPk( $phoneticData->phonetic_data_entity_id );
						if ( $model )
						{
							$results[ $phoneticData->phonetic_data_entity_id ] = $model;
							if ( $model instanceof Originator )
							{
								$resultInfo[ 'originator' ]++;
							}
							elseif ( $model instanceof OriginatorInfo )
							{
								$resultInfo[ 'origination account' ]++;
							}
							elseif ( $model instanceof PaymentProfile )
							{
								$resultInfo[ 'payment profile' ]++;
							}
						}
					}
				}

			}

			if ( count( $entryCriteria ) )
			{
				$criteria = new CDbCriteria();
				$criteria->addInCondition( 'ach_entry_detail_individual_id_number', $entryCriteria );
				$criteria->distinct = true;

				$entryResults = AchEntry::model()->findAll( $criteria );
				foreach ( $entryResults as $achEntry )
				{
					$resultInfo[ 'transaction' ]++;
					$results[ $achEntry->ach_entry_id ] = $achEntry;
					$resultCounts[ $achEntry->ach_entry_id ] = 1;
				}
			}

		}

		$this->render('index',array(
			'results'=>$results,
			'resultInfo'=>$resultInfo,
			'query'=>$query,
		));
	}

	public function actionIndex()
	{
		$query = Yii::app()->request->getParam( 'query' );
		$results = array();
		$resultInfo = array( 'originator'=>0, 'origination account'=>0, 'payment profile'=>0 );
		if ( $query )
		{
			$originators = Originator::model()->freeSearch( $query );
			if ( $originators )
			{
				$originatorList = $originators->getData();
				$results = array_merge( $results, $originatorList );
				$resultInfo['originator'] += count( $originatorList );
			}
			$originatorInfos = OriginatorInfo::model()->freeSearch( $query );
			if ( $originatorInfos )
			{
				$originatorInfoList = $originatorInfos->getData();
				$results = array_merge( $results, $originatorInfoList );
				$resultInfo['origination account'] += count( $originatorInfoList );
			}
			$paymentProfiles = PaymentProfile::model()->freeSearch( $query );
			if ( $paymentProfiles )
			{
				$paymentProfileList = $paymentProfiles->getData();
				$results = array_merge( $results, $paymentProfileList );
				$resultInfo['payment profile'] += count( $paymentProfileList );
			}

			if ( count( $results ) == 0 )
			{
				$this->fuzzySearch();
				return;
			}
		}
		$this->render('index',array(
			'results'=>$results,
			'resultInfo'=>$resultInfo,
			'query'=>$query,
		));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
