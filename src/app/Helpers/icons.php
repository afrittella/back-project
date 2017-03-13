<?php
if (!function_exists('icon')) {

    function icon($type, $options = "")
    {
        $icon = "fa-check";

        switch ($type):
            case 'add':
                $icon = "fa-plus";
                break;

            case 'edit':
                $icon = "fa-pencil";
                break;

            case 'delete':
                $icon = "fa-trash-o";
                break;

            case 'back':
                $icon = "fa-arrow-left";
                break;

            case 'next':
                $icon = "fa-arrow-right";
                break;

            case 'up':
                $icon = "fa-arrow-up";
                break;

            case 'down':
                $icon = "fa-arrow-down";
                break;

            case 'save':
                $icon = "fa-floppy-o";
                break;

            case 'dashboard':
                $icon = "fa-dashboard";
                break;

            // Print the icon parameter
            default:
                $icon = $type;
                break;
        endswitch;

        return \FontAwesome::icon($icon, $options);
    }
}