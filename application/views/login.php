<div class="d-flex justify-content-center align-items-center container">
    <div class="card py-5 px-3" id="phone_screen">
        <h5 class="m-0 text-center">Mobile phone verification</h5><span class="mobile-text text-center">Enter the 10 digit mobile number</span>
        
        <div class="d-flex flex-row mt-5">
            <input type="text" id="phone" class="form-control numeric_validation" minlength="10" maxlength="10" autofocus="" required>
        </div>
        
        <div class="text-center mt-5">
            <button type="button" class="btn font-weight-bold text-danger cursor border border-danger" id="get_otp">Get OTP</button>
        </div>
    </div>

    <div class="card py-5 px-3 d-none" id="otp_screen">
        <h5 class="m-0 text-center">Mobile phone verification</h5>
        <span class="mobile-text">Enter the code we just send on your mobile phone <b class="text-danger" id="phone_text"></b></span>
        
        <div class="d-flex flex-row mt-5">
            <input type="text" id="otp" class="form-control numeric_validation" minlength="4" maxlength="4" autofocus="" required>
        </div>

        <input type="hidden" name="session_details" id="session_details" value="">

        <div class="text-center mt-5">
            <button type="button" class="btn font-weight-bold text-danger cursor border border-danger" id="login">Login</button>
        </div>
        
        <!-- <div class="text-center mt-5"><span class="d-block mobile-text">Don't receive the code?</span><span class="font-weight-bold text-danger cursor">Resend</span></div> -->
    </div>
</div>