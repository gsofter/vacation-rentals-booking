<?php

namespace App\Traits;

use App\Models\Metas;
use Arcanedev\SeoHelper\Traits\Seoable;

/**
 * Trait MetaHelpers
 *
 * @package App\Traits
 */
trait MetaHelpers
{
	use Seoable;

	/**
	 * Sets default Basic, Opengraph & Twitter Card Meta
	 *
	 * @package Arcanedev\SeoHelper
	 *
	 * @param $model
	 */
	public function setMeta( $model ) {
		$this->setBasicMeta( $model );
		$this->setOpengraphMeta( $model );
		$this->setTwitterCardMeta( $model );
	}

	/**
	 * Set the default meta for the model
	 *
	 * @package Arcanedev\SeoHelper
	 *
	 * @param $model
	 */
	public function setBasicMeta( $model ) {
		$this->seo()
		     ->setTitle( $model->meta_title )
		     ->setDescription( $model->meta_description )
		     ->setKeywords( [ $model->meta_keywords ] );
	}

	/**
	 * Set the default open graph meta for the model
	 *
	 * @package Arcanedev\SeoHelper
	 *
	 * @param $model
	 */
	public function setOpenGraphMeta( $model ) {
		$this->seo()->openGraph()
		     ->setTitle( $model->meta_title )
		     ->setDescription( $model->meta_description )
		     ->setUrl( $model->route )
		     ->setImage( $model->image_url );
	}

	/**
	 * Set the default twitter card meta for the model
	 *
	 * @package Arcanedev\SeoHelper
	 *
	 * @param $model
	 */
	public function setTwitterCardMeta( $model ) {
		$this->seo()->twitter()
		     ->setTitle( $model->meta_title )
		     ->setDescription( $model->meta_description )
		     ->addMeta( 'url', $model->route )
		     ->addImage( $model->image_url );
	}

	/**
	 * Store Opengraph Meta in the permalink model
	 *
	 * @param $model
	 */
	public function storeOpenGraphMeta( $model ) {
		$model->permalink->update( [
			'seo.opengraph.title'       => $model->permalink->seo['meta']['title'],
			'seo.opengraph.description' => $model->permalink->seo['meta']['description'],
			'seo.opengraph.image'       => $model->image_url,
		] );
	}

	/**
	 * Store Twitter card meta in the permalink model
	 *
	 * @param $model
	 */
	public function storeTwitterCardMeta( $model ) {
		$model->permalink->update( [
			'seo.twitter.title'       => $model->permalink->seo['meta']['title'],
			'seo.twitter.description' => $model->permalink->seo['meta']['description'],
			'seo.twitter.image'       => $model->image_url,
			'seo.twitter.url'         => $model->route
		] );
	}

	/**
	 * Dynamic Function for Showing Meta Details
	 * @param $url
	 * @param $field
	 * @deprecated
	 * @return string
	 */
	public static function meta($url, $field)
	{
		$metas = Metas::where('url', $url);

		if($metas->count()) {
			return $metas->first()->$field;
		}

		if( $field == 'title') {
			return 'Vacation.Rentals';
		}

		if( $field == 'description') {
			return 'Find perfect vacation rentals for your next trip from private owners and property managers. Rent direct with no booking fees, no commissions, no hidden charges. We make the introduction and leave the rest up to you.';
		}

		if ( $field == 'keywords') {
			return 'vacation, rentals, property, manager, owner, no, fees, commissions, direct, ';
		}

		if( $field == 'meta_image') {
			return LOGO_URL;
		}

		return '';
	}
}