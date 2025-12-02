<?php

// vamtam_theme_supports - Modified to work without VamTam theme
if ( ! function_exists( 'vamtam_theme_supports' ) ) {
    function vamtam_theme_supports( $feature, $relation = 'OR' ) {
        // Enable all features by default when not using VamTam theme
        $supported = true;
    
        if ( is_array( $feature ) ) {
            // Multiple features - check if any theme support exists
            $has_theme_support = false;
            foreach ( $feature as $ftr ) {
                if ( current_theme_supports( $ftr ) || current_theme_supports( 'vamtam-elementor-widgets', $ftr ) ) {
                    $has_theme_support = true;
                    break;
                }
            }
            
            // If theme explicitly supports something, use that. Otherwise enable by default.
            if ( $has_theme_support ) {
                $not_supported_found = false;
                foreach ( $feature as $ftr ) {
                    if ( current_theme_supports( $ftr ) || current_theme_supports( 'vamtam-elementor-widgets', $ftr ) ) {
                        if ( $relation === 'OR' ) {
                            $supported = true;
                            break;
                        }
                    } else {
                        if ( $relation === 'AND' ) {
                            $not_supported_found = true;
                            break;
                        }
                    }
                }
        
                if ( $relation === 'AND' && $not_supported_found === false ) {
                    $supported = true;
                }
            }
        } else {
            // Single feature - enable by default or check theme support if declared
            if ( current_theme_supports( $feature ) || current_theme_supports( 'vamtam-elementor-widgets', $feature ) ) {
                $supported = true;
            }
            // Already true by default, so no else needed
        }
    
        return $supported;
    }
}