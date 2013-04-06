<!-- This file is used to markup the administration form of the widget. -->

<p>
    <label for="<?php echo $this->get_field_id( 'event' ); ?>"><?php _e( 'Event:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'event' ); ?>" name="<?php echo $this->get_field_name( 'event' ); ?>" type="text" value="<?php echo esc_attr( $event ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'band_name' ); ?>"><?php _e( 'Band Name:' ); ?></label>
    <input class="widefat jw-band-name" id="<?php echo $this->get_field_id( 'band_name' ); ?>" name="<?php echo $this->get_field_name( 'band_name' ); ?>" type="text" value="<?php echo esc_attr( $band_name ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'event_time' ); ?>"><?php _e( 'Event Time:' ); ?></label>
    <input class="widefat jw-event-time" id="<?php echo $this->get_field_id( 'event_time' ); ?>" name="<?php echo $this->get_field_name( 'event_time' ); ?>" type="text" value="<?php echo esc_attr( $event_time ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'event_date' ); ?>"><?php _e( 'Event Date:' ); ?></label>
    <input class="widefat jw-event-date" id="<?php echo $this->get_field_id( 'event_date' ); ?>" name="<?php echo $this->get_field_name( 'event_date' ); ?>" type="text" value="<?php echo esc_attr( $event_date ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'live_message' ); ?>"><?php _e( 'Live message:' ); ?></label>
    <input class="widefat jw-live-message" id="<?php echo $this->get_field_id( 'live_message' ); ?>" name="<?php echo $this->get_field_name( 'live_message' ); ?>" type="text" value="<?php echo esc_attr( $live_message ); ?>" />
</p>
