<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable\Filter;

use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NumberRangeFilter
 *
 * @package Sg\DatatablesBundle\Datatable\Filter
 */
class NumberRangeFilter extends AbstractFilter
{
    /**
     * @var string
     */
    private $minPlaceholder;

    /**
     * @var string
     */
    private $maxPlaceholder;

    //-------------------------------------------------
    // FilterInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'SgDatatablesBundle:Filters:filter_numberrange.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function addAndExpression(Andx $andExpr, QueryBuilder $pivot, $searchField, $searchValue, &$i)
    {
        $array = explode(',', $searchValue);
        list($searchMin, $searchMax) = $array;

        if (!empty($searchMin)) {
            $andExpr->add($pivot->expr()->gte($searchField, '?' . $i));
            $pivot->setParameter($i, $searchMin);
            $i++;
        }

        if (!empty($searchMax)) {
            $andExpr->add($pivot->expr()->lte($searchField, '?' . $i));
            $pivot->setParameter($i, $searchMax);
            $i++;
        }

        return $andExpr;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'numberrange';
    }

    //-------------------------------------------------
    // OptionsInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'search_type' => 'eq',
            'property' => '',
            'search_column' => '',
            'class' => '',
            'cancel_button' => false,
            'min_placeholder' => 'min',
            'max_placeholder' => 'max',
        ));

        $resolver->setAllowedTypes('search_type', 'string');
        $resolver->setAllowedTypes('property', 'string');
        $resolver->setAllowedTypes('search_column', 'string');
        $resolver->setAllowedTypes('class', 'string');
        $resolver->setAllowedTypes('cancel_button', 'bool');
        $resolver->setAllowedTypes('min_placeholder', 'string');
        $resolver->setAllowedTypes('max_placeholder', 'string');

        $resolver->setAllowedValues('search_type', array('like', 'notLike', 'eq', 'neq', 'lt', 'lte', 'gt', 'gte', 'in', 'notIn', 'isNull', 'isNotNull'));

        return $this;
    }

    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * @return string
     */
    public function getMinPlaceholder()
    {
        return $this->minPlaceholder;
    }

    /**
     * @param string $minPlaceholder
     *
     * @return $this
     */
    public function setMinPlaceholder($minPlaceholder)
    {
        $this->minPlaceholder = $minPlaceholder;

        return $this;
    }

    /**
     * @return string
     */
    public function getMaxPlaceholder()
    {
        return $this->maxPlaceholder;
    }

    /**
     * @param string $maxPlaceholder
     *
     * @return $this
     */
    public function setMaxPlaceholder($maxPlaceholder)
    {
        $this->maxPlaceholder = $maxPlaceholder;

        return $this;
    }
}
