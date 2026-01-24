$(document).ready(function(){

    let selectedFiles = [];
    let serialValid = false;

    // ---------------- Dynamic Xaalada2 Logic ----------------
    function toggleXaalada2() {
        let x1 = $('#Xaalada1').val();

        // clean errors
        $('.Xaalada2A_error, .Xaalada2B_error, .Xaalada2C_error').text('');
        $('.dynamic-field').removeClass('is-valid is-invalid');

        // hide all
        $('#stateA, #stateB').addClass('d-none');

        if (x1 === '0') {
            $('#stateA').removeClass('d-none');
            $('#Xaalada2A').attr('required', true);
            $('#Xaalada2B, #Xaalada2C').attr('required', false);
        } else if (x1 === '1') {
            $('#stateB').removeClass('d-none');
            $('#Xaalada2B, #Xaalada2C').attr('required', true);
            $('#Xaalada2A').attr('required', false);
        }
    }

    $('#Xaalada1').on('change', toggleXaalada2);
    toggleXaalada2(); // initial call

    // ---------------- Preview Multiple Images ----------------
    $('#sawiradaHubka').on('change', function(){
        const files = Array.from(this.files);
        if ((selectedFiles.length + files.length) > 12) {
            Swal.fire({ icon:'error', title:'Oops!', text:'You can only upload up to 12 images.' });
            return;
        }

        files.forEach(file => {
            if(file.type.startsWith('image/')){
                selectedFiles.push(file);
                let reader = new FileReader();
                reader.onload = function(e){
                    let imgWrapper = $(`
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-thumbnail" width="100"/>
                            <button type="button" class="btn btn-sm btn-danger remove-image">&times;</button>
                        </div>
                    `);
                    imgWrapper.find('.remove-image').on('click', function(){
                        const index = $('#preview-container .position-relative').index(imgWrapper);
                        selectedFiles.splice(index, 1);
                        imgWrapper.remove();
                    });
                    $('#preview-container').append(imgWrapper);
                }
                reader.readAsDataURL(file);
            }
        });

        $(this).val('');
    });

    // ---------------- Field Validation ----------------
    function validateField(field) {
        let value = $(field).val();
        let id = $(field).attr('id');
        let isValid = true;

        if($(field).attr('type') === 'file') {
            if(selectedFiles.length === 0){
                $('.' + id + '_error').text('Please select at least one image');
                $(field).addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            } else {
                $('.' + id + '_error').text('');
                $(field).addClass('is-valid').removeClass('is-invalid');
            }
        } else if ($(field).prop('required') && (!value || value === '')) {
            $('.' + id + '_error').text('This field is required');
            $(field).addClass('is-invalid').removeClass('is-valid');
            isValid = false;
        } else {
            $('.' + id + '_error').text('');
            $(field).addClass('is-valid').removeClass('is-invalid');
        }
        return isValid;
    }

    $('#keydinForm input, #keydinForm select, #keydinForm textarea').on('input change', function(){
        validateField(this);
    });

    // ---------------- LambarkaTaxanaha Validation ----------------
    $('#LambarkaTaxanaha').on('blur', function(){
        let serial = $(this).val();
        let hubId = $('#QaybtaHubka').val();

        if(!hubId){
            $('.LambarkaTaxanaha_error').text('Fadlan dooro qaybta hubka ka hor inta aanad gelin lambarka taxanaha.');
            $(this).addClass('is-invalid').removeClass('is-valid');
            serialValid = false;
            Swal.fire({ icon:'error', title:'Oops!', text:'Fadlan dooro qaybta hubka ka hor inta aanad gelin lambarka taxanaha.' });
            return;
        }

        if(!serial){
            $('.LambarkaTaxanaha_error').text('This field is required');
            $(this).addClass('is-invalid').removeClass('is-valid');
            serialValid = false;
            Swal.fire({ icon:'error', title:'Oops!', text:'Fadlan geli Lambarka Taxanaha.' });
            return;
        }

        $.ajax({
            url: "/keydin/checkSerial", // update route if needed
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                LambarkaTaxanaha: serial,
                QaybtaHubka: hubId
            },
            success: function(res){
                if(res.exists){
                    $('.LambarkaTaxanaha_error').text('Serial-kan iyo hubkan hore ayaa loo diiwaangeliyay!');
                    $('#LambarkaTaxanaha').addClass('is-invalid').removeClass('is-valid');
                    serialValid = false;
                    Swal.fire({ icon:'error', title:'Oops!', text:'Serial-kan hore ayaa la isticmaalay!' });
                } else {
                    $('.LambarkaTaxanaha_error').text('');
                    $('#LambarkaTaxanaha').addClass('is-valid').removeClass('is-invalid');
                    serialValid = true;
                    Swal.fire({ icon:'success', title:'Available!', text:'Serial-kan waa la isticmaali karaa.' });
                }
            },
            error: function(){
                serialValid = false;
                Swal.fire({ icon:'error', title:'Server Error', text:'Hubinta serial-ka way fashilantay!' });
            }
        });
    });

    // ---------------- Submit Form ----------------
    function getFormData(form){
        let formData = new FormData(form);
        selectedFiles.forEach(file => formData.append('sawiradaHubka[]', file));
        return formData;
    }

    $('#keydinForm').submit(function(e){
        e.preventDefault();
        let isFormValid = true;

        $('#keydinForm input, #keydinForm select, #keydinForm textarea').each(function(){
            if($(this).is(':visible') && $(this).attr('id') !== 'LambarkaTaxanaha' && !validateField(this))
                isFormValid = false;
        });

        if(!serialValid){
            $('#LambarkaTaxanaha').addClass('is-invalid').removeClass('is-valid');
            $('.LambarkaTaxanaha_error').text('Please enter a valid serial');
            isFormValid = false;
        }

        if(!isFormValid){
            Swal.fire({ icon:'error', title:'Oops!', text:'Please fix the highlighted errors!' });
            return;
        }

        const saveBtn = $('#saveBtn');
        const originalBtnHtml = saveBtn.html();
        saveBtn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

        let formData = getFormData(this);

        $.ajax({
            type: 'POST',
            url: "/keydin/store", // update route if needed
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                saveBtn.html(originalBtnHtml).prop('disabled', false);
                Swal.fire({ icon:'success', title:'Success!', text: res.message || 'Keydin added', timer:2000, showConfirmButton:false })
                    .then(()=>{ window.location.href="/keydin"; });
            },
            error: function(err){
                saveBtn.html(originalBtnHtml).prop('disabled', false);
                $('.error-text').text('');
                $('#keydinForm input, #keydinForm select, #keydinForm textarea').removeClass('is-valid is-invalid');
                if(err.responseJSON && err.responseJSON.errors){
                    $.each(err.responseJSON.errors, function(key,val){
                        $('.'+key+'_error').text(val[0]);
                        $('#' + key).addClass('is-invalid');
                    });
                }
                Swal.fire({ icon:'error', title:'Oops!', text:'Please fix errors!' });
            }
        });

    });

});
