<?php
/**
 * File containing the ezcGraphChartElementLabeledAxis class
 *
 * @package Graph
 * @version 1.2
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a labeled axis. Values on the x axis are considered as 
 * strings and used in the given order.
 *
 * @property float $labelCount
 *           Define count of displayed labels on the axis
 * 
 * @version 1.2
 * @package Graph
 * @mainclass
 */
class ezcGraphChartElementLabeledAxis extends ezcGraphChartElementAxis
{
    
    /**
     * Array with labeles for data 
     * 
     * @var array
     */
    protected $labels = array();

    /**
     * Reduced amount of labels which will be displayed in the chart
     * 
     * @var array
     */
    protected $displayedLabels = array();

    /**
     * Maximum count of labels which can be displayed on one axis
     * @todo Perhaps base this on the chart size
     */
    const MAX_LABEL_COUNT = 10;

    /**
     * Precalculated steps on the axis
     * 
     * @var array(ezcGraphAxisStep)
     */
    protected $steps;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['labelCount'] = null;

        $this->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();

        parent::__construct( $options );
    }

    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBaseValueException
     *          If a submitted parameter was out of range or type.
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'labelCount':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int > 1' );
                }

                $this->properties['labelCount'] = (int) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Increase the keys of all elements in the array up from the start key, to
     * insert an additional element at the correct position.
     * 
     * @param array $array Array
     * @param int $startKey Key to increase keys from
     * @return array Updated array
     */
    protected function increaseKeys( array $array, $startKey )
    {
        foreach ( $array as $key => $value )
        {
            if ( $key === $startKey )
            {
                // Recursive check, if next key should be increased, too
                if ( isset ( $array[$key + 1] ) )
                {
                    $array = $this->increaseKeys( $array, $key + 1 );
                }

                // Increase key
                $array[$key + 1] = $array[$key];
                unset( $array[$key] );
            }
        }

        return $array;
    }

    /**
     * Add data for this axis
     * 
     * @param array $values Value which will be displayed on this axis
     * @return void
     */
    public function addData( array $values )
    {
        $position = 0;
        foreach ( $values as $label )
        {
            $label = (string) $label;

            if ( !in_array( $label, $this->labels, true ) )
            {
                if ( isset( $this->labels[$position] ) )
                {
                    $this->labels = $this->increaseKeys( $this->labels, $position );
                    $this->labels[$position++] = $label;
                }
                else
                {
                    $this->labels[$position++] = $label;
                }
            }
            else 
            {
                $position = array_search( $label, $this->labels, true ) + 1;
            }
        }
        ksort( $this->labels );

        $this->properties['initialized'] = true;
    }

    /**
     * Calculate axis bounding values on base of the assigned values 
     * 
     * @abstract
     * @access public
     * @return void
     */
    public function calculateAxisBoundings()
    {
        $this->steps = array();

        // Apply label format callback function
        if ( $this->properties['labelCallback'] !==  null )
        {
            foreach ( $this->labels as $nr => $label )
            {
                $this->labels[$nr] = call_user_func_array(
                    $this->properties['labelCallback'],
                    array(
                        $label,
                        $nr
                    )
                );
            }
        }

        $labelCount = count( $this->labels ) - 1;

        if ( $labelCount === 0 )
        {
            // Create single only step
            $this->steps = array(
                new ezcGraphAxisStep(
                    0,
                    1,
                    reset( $this->labels ),
                    array(),
                    true,
                    true
                ),
            );

            return true;
        }

        if ( $this->properties['labelCount'] === null )
        {
            if ( $labelCount <= self::MAX_LABEL_COUNT )
            {
                $stepSize = 1 / $labelCount;

                foreach ( $this->labels as $nr => $label )
                {
                    $this->steps[] = new ezcGraphAxisStep(
                        $stepSize * $nr,
                        $stepSize,
                        $label,
                        array(),
                        $nr === 0,
                        $nr === $labelCount
                    );
                }

                // @TODO: This line is deprecated and only build for 
                // deprecated getLabel()
                $this->displayedLabels = $this->labels;

                return true;
            }

            for ( $div = self::MAX_LABEL_COUNT; $div > 1; --$div )
            {
                if ( ( $labelCount % $div ) === 0 )
                {
                    // @TODO: This part is deprecated and only build for 
                    // deprecated getLabel()
                    $step = $labelCount / $div;

                    foreach ( $this->labels as $nr => $label )
                    {
                        if ( ( $nr % $step ) === 0 )
                        {
                            $this->displayedLabels[] = $label;
                        }
                    }
                    // End of deprecated part

                    break;
                }
            }
        }
        else
        {
            $div = false;
        }

        // Build up step array
        if ( $div > 2 )
        {
            $step = $labelCount / $div;
            $stepSize = 1 / $div;
            $minorStepSize = $stepSize / $step;

            foreach ( $this->labels as $nr => $label )
            {
                if ( ( $nr % $step ) === 0 )
                {
                    $mainstep = new ezcGraphAxisStep(
                        $stepSize * ( $nr / $step ),
                        $stepSize,
                        $label,
                        array(),
                        $nr === 0,
                        $nr === $labelCount
                    );

                    $this->steps[] = $mainstep;
                }
                else
                {
                    $mainstep->childs[] = new ezcGraphAxisStep(
                        $mainstep->position + $minorStepSize * ( $nr % $step ),
                        $minorStepSize
                    );
                }
            }
        }
        else
        {
            if ( $this->properties['labelCount'] === null )
            {
                $floatStep = $labelCount / ( self::MAX_LABEL_COUNT - 1 );
            }
            else
            {
                $floatStep = $labelCount / min( $labelCount, $this->properties['labelCount'] - 1 );
            }

            $position = 0;
            $minorStepSize = 1 / $labelCount;
            
            foreach ( $this->labels as $nr => $label )
            {
                if ( $nr >= $position )
                {
                    $position += $floatStep;

                    // Add as major step
                    $mainstep = new ezcGraphAxisStep(
                        $minorStepSize * $nr,
                        ceil( $position - $nr ) * $minorStepSize,
                        $label,
                        array(),
                        $nr === 0,
                        $nr === $labelCount
                    );

                    // @TODO: This line is deprecated and only build for 
                    // deprecated getLabel()
                    $this->displayedLabels[] = $label;

                    $this->steps[] = $mainstep;
                }
                else
                {
                    $mainstep->childs[] = new ezcGraphAxisStep(
                        $minorStepSize * $nr,
                        $minorStepSize
                    );
                }
            }
        }
    }

    /**
     * Return array of steps on this axis
     * 
     * @return array( ezcGraphAxisStep )
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Get coordinate for a dedicated value on the chart
     * 
     * @param string $value Value to determine position for
     * @return float Position on chart
     */
    public function getCoordinate( $value )
    {
        if ( $value === false || 
             $value === null  ||
             ( $key = array_search( $value, $this->labels ) ) === false )
        {
            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::TOP:
                    return 0.;
                case ezcGraph::RIGHT:
                case ezcGraph::BOTTOM:
                    return 1.;
            }
        }
        else
        {
            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::TOP:
                    if ( count( $this->labels ) > 1 )
                    {
                        return (float) $key / ( count ( $this->labels ) - 1 );
                    }
                    else
                    {
                        return 0;
                    }
                case ezcGraph::BOTTOM:
                case ezcGraph::RIGHT:
                    if ( count( $this->labels ) > 1 )
                    {
                        return (float) 1 - $key / ( count ( $this->labels ) - 1 );
                    }
                    else
                    {
                        return 1;
                    }
            }
        }
    }

    /**
     * Return count of minor steps
     * 
     * @return integer Count of minor steps
     */
    public function getMinorStepCount()
    {
        return 0;
    }

    /**
     * Return count of major steps
     * 
     * @return integer Count of major steps
     */
    public function getMajorStepCount()
    {
        return max( count( $this->displayedLabels ) - 1, 1 );
    }

    /**
     * Get label for a dedicated step on the axis
     * 
     * @param integer $step Number of step
     * @return string label
     */
    public function getLabel( $step )
    {
        if ( isset( $this->displayedLabels[$step] ) )
        {
            return $this->displayedLabels[$step];
        }
        else
        {
            return false;
        }
    }

    /**
     * Is zero step
     *
     * Returns true if the given step is the one on the initial axis position
     * 
     * @param int $step Number of step
     * @return bool Status If given step is initial axis position
     */
    public function isZeroStep( $step )
    {
        return !$step;
    }
}

?>
