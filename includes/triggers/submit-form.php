<?php
/**
 * Submit Form
 *
 * @package     AutomatorWP\Integrations\Elementor_Forms\Triggers\Submit_Form
 * @author      AutomatorWP <contact@automatorwp.com>, Ruben Garcia <rubengcdev@gmail.com>
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AutomatorWP_Elementor_Forms_Submit_Form extends AutomatorWP_Integration_Trigger {

    public $integration = 'elementor';
    public $trigger = 'elementor_forms_submit_form';

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        automatorwp_register_trigger( $this->trigger, array(
            'integration'       => $this->integration,
            'label'             => __( 'User submits a form', 'automatorwp-elementor-forms' ),
            'select_option'     => __( 'User submits <strong>a form</strong>', 'automatorwp-elementor-forms' ),
            /* translators: %1$s: Form name. %2$s: Number of times. */
            'edit_label'        => sprintf( __( 'User submits %1$s %2$s time(s)', 'automatorwp-elementor-forms' ), '{form_name}', '{times}' ),
            /* translators: %1$s: Form name. */
            'log_label'         => sprintf( __( 'User submits %1$s', 'automatorwp-elementor-forms' ), '{form_name}' ),
            'action'            => 'elementor_pro/forms/new_record',
            'function'          => array( $this, 'listener' ),
            'priority'          => 10,
            'accepted_args'     => 2,
            'options'           => array(
                'form_name' => array(
                    'from' => 'form_name',
                    'default' => __( 'any form', 'automatorwp-elementor-forms' ),
                    'fields' => array(
                        'form_name' => array(
                            'name' => __( 'Form name:', 'automatorwp-elementor-forms' ),
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                'times' => automatorwp_utilities_times_option(),
            ),
            'tags' => array_merge(
                array(
                    'form_field:FIELD_ID' => array(
                        'label'     => __( 'Form field value', 'automatorwp-elementor-forms' ),
                        'type'      => 'text',
                        'preview'   => __( 'Form field value, replace "FIELD_ID" by the field id', 'automatorwp-elementor-forms' ),
                    ),
                ),
                automatorwp_utilities_times_tag()
            )
        ) );

    }

    /**
     * Trigger listener
     *
     * @since 1.0.0
     *
     * @param Form_Record $record
     * @param Ajax_Handler $handler
     */
    public function listener( $record, $handler ) {

        $form_name = $record->get_form_settings( 'form_name' );
        $user_id = get_current_user_id();

        // Login is required
        if ( $user_id === 0 ) {
            return;
        }

        $form_fields = automatorwp_elementor_forms_get_form_fields_values( $record );

        // Trigger submit form event
        automatorwp_trigger_event( array(
            'trigger'       => $this->trigger,
            'user_id'       => $user_id,
            'form_name'     => $form_name,
            'form_fields'   => $form_fields,
        ) );

    }

    /**
     * User deserves check
     *
     * @since 1.0.0
     *
     * @param bool      $deserves_trigger   True if user deserves trigger, false otherwise
     * @param stdClass  $trigger            The trigger object
     * @param int       $user_id            The user ID
     * @param array     $event              Event information
     * @param array     $trigger_options    The trigger's stored options
     * @param stdClass  $automation         The trigger's automation object
     *
     * @return bool                          True if user deserves trigger, false otherwise
     */
    public function user_deserves_trigger( $deserves_trigger, $trigger, $user_id, $event, $trigger_options, $automation ) {

        // Don't deserve if form name is not received
        if( ! isset( $event['form_name'] ) ) {
            return false;
        }

        // Don't deserve if form name doesn't match with the trigger option
        if( ! empty( $trigger_options['form_name'] ) && $event['form_name'] !== $trigger_options['form_name'] ) {
            return false;
        }

        return $deserves_trigger;

    }

    /**
     * Register the required hooks
     *
     * @since 1.0.0
     */
    public function hooks() {

        // Log meta data
        add_filter( 'automatorwp_user_completed_trigger_log_meta', array( $this, 'log_meta' ), 10, 6 );

        // Log fields
        add_filter( 'automatorwp_log_fields', array( $this, 'log_fields' ), 10, 5 );

        parent::hooks();
    }

    /**
     * Trigger custom log meta
     *
     * @since 1.0.0
     *
     * @param array     $log_meta           Log meta data
     * @param stdClass  $trigger            The trigger object
     * @param int       $user_id            The user ID
     * @param array     $event              Event information
     * @param array     $trigger_options    The trigger's stored options
     * @param stdClass  $automation         The trigger's automation object
     *
     * @return array
     */
    function log_meta( $log_meta, $trigger, $user_id, $event, $trigger_options, $automation ) {

        // Bail if action type don't match this action
        if( $trigger->type !== $this->trigger ) {
            return $log_meta;
        }

        $log_meta['form_fields'] = ( isset( $event['form_fields'] ) ? $event['form_fields'] : array() );

        return $log_meta;

    }

    /**
     * Action custom log fields
     *
     * @since 1.0.0
     *
     * @param array     $log_fields The log fields
     * @param stdClass  $log        The log object
     * @param stdClass  $object     The trigger/action/automation object attached to the log
     *
     * @return array
     */
    public function log_fields( $log_fields, $log, $object ) {

        // Bail if log is not assigned to an trigger
        if( $log->type !== 'trigger' ) {
            return $log_fields;
        }

        // Bail if trigger type don't match this trigger
        if( $object->type !== $this->trigger ) {
            return $log_fields;
        }

        $log_fields['form_fields'] = array(
            'name' => __( 'Fields Submitted', 'automatorwp-elementor-forms' ),
            'desc' => __( 'Information about the fields values sent on this form submission.', 'automatorwp-elementor-forms' ),
            'type' => 'text',
        );

        return $log_fields;

    }

}

new AutomatorWP_Elementor_Forms_Submit_Form();