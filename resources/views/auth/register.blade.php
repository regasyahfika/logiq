@extends('layouts.app')
@section('style')
<style>
    body {
        margin-top: 40px;
    }

    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    .has-error .form-control {
        border-color: #a94442;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    }

</style>
@endsection
@section('content')
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                <p>Step 1</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p>Step 2</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p>Step 3</p>
            </div>
        </div>
    </div>
    <form role="form" action="{{ route('api/register') }}">
        <div class="row setup-content" id="step-1">
            <div class="col-md-12">
                <h3> Step 1</h3>
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input maxlength="100" name="first_name" type="text" class="form-control"
                        placeholder="Enter First Name" />
                </div>
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input maxlength="100" name="last_name" type="text" required="required"
                        class="form-control validation" placeholder="Enter Last Name" />
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input maxlength="100" name="email" type="email" required="required" class="form-control validation"
                        placeholder="Enter Email" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input name="password" type="password" required="required" class="form-control validation"
                        placeholder="Password" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password Confimation</label>
                    <input name="password_confirmation" type="password" required="required"
                        class="form-control validation" placeholder="Password Confirmation" />
                </div>

                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
            </div>
        </div>
        <div class="row setup-content" id="step-2">
            <div class="col-xs-12">
                <div class="col-md-12 wrapper-add">
                    <h3> Step 2</h3>
                    <div class="form-group form-add">
                        <label class="control-label">Address</label>
                        <textarea name="address" required="required" id="address" cols="200" rows="3"
                            class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary btn-xs pull-right" type="button" id="add">Add</button>
                    <button class="btn btn-primary btn-xs pull-right" type="button" id="remove" style="display: none">Remove</button>
                    <div class="form-group">
                        <label class="control-label">Birthday</label>
                        <input type="date" name="birthday" class="form-control" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <select name="gender" id="gender" required="required" class="form-control">
                            <option value="male">Male</option>
                            <option value="famale">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Membership</label>
                        <select name="membership_id" id="membership_id" required="required" class="form-control">
                            <option value="silver">Silver</option>
                            <option value="gold">Gold</option>
                            <option value="platinum">Platinum</option>
                            <option value="black">Black</option>
                            <option value="vip">VIP</option>
                            <option value="vvip">VVIP</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">CC Number</label>
                        <input name="cc_number" type="text" required="required"
                            class="form-control validation" placeholder="CC Number" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">CC expired Month</label>
                        <input type="number" name="month" class="form-control" placeholder="Month, example 12">
                    </div>
                    <div class="form-group">
                        <label class="control-label">CC expired Year</label>
                        <input type="number" name="year" class="form-control" placeholder="Year, example 2020">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Credit Card Type</label>
                        <select name="credit_card_type" id="credit_card_type" required="required" class="form-control">
                            <option value="visa">Visa</option>
                            <option value="master">Master</option>
                        </select>
                    </div>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                </div>
            </div>
        </div>
        <div class="row setup-content" id="step-3">
            <div class="col-xs-12">
                <div class="col-md-12">
                    <h3> Step 3</h3>
                    <button class="btn btn-success btn-lg pull-right" type="submit">Finish!</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {

        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function () {
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent()
                .next().children("a"),
                curInputs = curStep.find(".validation"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }
            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });
        $('div.setup-panel div a.btn-primary').trigger('click');

        $(document).on('click', '#add', function () {
            $(".form-add:last").clone().insertBefore(this);
            $('#remove').show();
        });
        $(document).on('click', '#remove', function(e) {
            $(this).closest(".wrapper-add").find('.form-add').last().remove();
            $('#remove').hide();
            e.preventDefault();
        });

    });

</script>
@endsection
