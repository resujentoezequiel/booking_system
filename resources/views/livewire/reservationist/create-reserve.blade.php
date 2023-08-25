<div x-data="{}">
    <x-dialog />

    <x-button style="width: 100%" lg onclick="openModalCreateReservation()" label="CREATE RESERVATION" dark/>

    <x-modal blur wire:model.defer="appendData">
        <x-card title="Consent Terms">
            <form action="{{ route('create_reservation') }}">
                @csrf

                <x-select
                    id="room_id"
                    name="room_id"
                    label="Room List"
                    placeholder="Select room list"
                    :async-data="route('room_list')"
                    option-label="name"
                    option-value="id"
                />
                <br>

                <x-datetime-picker
                    id="appointment_date"
                    name="appointment_date"
                    label="Appointment Date"
                    placeholder="Select Appointment Date and Start Time"
                    min-time="07:00"
                    max-time="16:15"
                    interval="15"
                    parse-format="DD-MM-YYYY HH:mm"
                    without-timezone
                />
                <br>

                <x-inputs.number id="minutes_count" name="minutes_count" label="How many minutes?" />


                <button id="legitBtn" primary label="Done" type="submit" style="visibility: hidden" />

                <div class="flex justify-end gap-x-4">
                    <x-button style="width: 100%; margin-top: 2rem" dark label="SUBMIT" onclick="fakeAddSubmit()"/>
                </div>

            </form>
        </x-card>
    </x-modal>

</div>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function fakeAddSubmit(){

        const appointment_date = document.getElementById("appointment_date").value;
        const room_id = document.getElementById("room_id").value;
        const minutes_count = document.getElementById("minutes_count").value;

        const d1 = new Date(appointment_date);
        const check_day = d1.getDay();
        const date_current = new Date();

        if (new Date(appointment_date).getTime() <= date_current.getTime()) {
            Swal.fire(
                'ALERT',
                'Please select current time or future date.',
                'error'
            )
        } else if(check_day == "0" || check_day == "6"){
            Swal.fire(
                'ALERT',
                'The day you is select is weekend.',
                'error'
            )
        } else if(minutes_count <= "14"){
            Swal.fire(
                'ALERT',
                'The minutes allowed is greater than or equal to 15',
                'error'
            )
        } else if (minutes_count >= "61"){
            Swal.fire(
                'ALERT',
                'The minutes allowed is less than or equal to 60',
                'error'
            )
        } else if (minutes_count == ""){
            Swal.fire(
                'ALERT',
                'Please enter how many minutes.',
                'error'
            )
        }  else if (appointment_date == ""){
            Swal.fire(
                'ALERT',
                'Please select appointment date and time.',
                'error'
            )
        }  else if (room_id == ""){
            Swal.fire(
                'ALERT',
                'Please select a room.',
                'error'
            )
        } else {

            $.ajax({
                url:'./check_room/',
                type:'POST',
                data:{"appointment_date":appointment_date, "room_id":room_id},
                success:function(data){
                    if(data != ""){
                        Swal.fire(
                            'ALERT',
                            'Please select another time because the time of the room you selected is already occupied.',
                            'error'
                        )
                    } else {
                        document.getElementById("legitBtn").click();
                    }

                }
            });
        }
    }

    function openModalCreateReservation(){
        $openModal('appendData');
    }

</script>
