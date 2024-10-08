<style>
    /* Print Styles */
    @media print {
        /* General Reset */
        body, h1, p {
            margin: 0;
            padding: 0;
        }

        /* Remove background images and colors for print */
        body {
            background: none;
            color: #000;
        }

        /* Page layout adjustments */
        .container-fluid {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .card {
            border: 1px solid #000;
            border-radius: 0;
            margin-bottom: 20px;
            padding: 10px;
            page-break-inside: avoid; /* Prevent page breaks inside card */
        }

        .card-header {
            background-color: #e9ecef;
            border-bottom: 1px solid #000;
            padding: 5px;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            border: 1px solid #000;
            background: none;
            padding: 5px;
            font-size: 14px;
            width: 100%;
        }

        /* Hide elements not needed in print */
        .no-print, .btn, .card-header {
            display: none;
        }

        /* Header and Footer */
        @page {
            margin: 20mm;
        }
    }
</style>
<div class="container-fluid">
    <?php
    $row=$param['row'];
    ?>
    <div class="card col-lg-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('project/supplier') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <!-- form -->
            <form action="#" method="post">
                <input type="hidden" name="supplier_id" id="supplier_id" value="<?= $row['supplier_id']; ?>" />
                <div class=" col-lg-12 ">
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="menu">الاسم</label>
                            <input type="text" value="<?= $row['supplier_name']; ?>"  class="form-control" id="supplier_name" name="supplier_name" placeholder="الاسم" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="menu">اسم التخاطب</label>
                            <input type="text" value="<?= $row['contact_name']; ?>" class="form-control" id="contact_name" name="contact_name" placeholder="اسم التخاطب"readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="menu">الايميل </label>
                            <input type="text" value="<?= $row['contact_email']; ?>" class="form-control" id="contact_email" name="contact_email" placeholder="البريد "readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="menu">جوال </label>
                            <input type="text" value="<?= $row['contact_phone']; ?>"  class="form-control" id="contact_phone" name="contact_phone" placeholder="جوال"readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="menu">الدولة </label>
                            <input type="text" value="<?= $row['country']; ?>"  class="form-control" id="country" name="country" placeholder="دولة"readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="menu">ولاية </label>
                            <input type="text" value="<?= $row['state']; ?>"class="form-control" id="state" name="state" placeholder="ولاية"readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="menu">مدينة </label>
                            <input type="text" value="<?= $row['city']; ?>" class="form-control" id="city" name="city" placeholder="مدينة"readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu">عنوان </label>
                        <input type="text" value="<?= $row['address']; ?>" class="form-control" id="address" name="address" placeholder="عنوان"readonly>
                    </div>
                    <div class="form-group row">
                        <label for="menu">رمز بريدي </label>
                        <input type="text" value="<?= $row['postal_code']; ?>" class="form-control" id="postal_code" name="postal_code" placeholder="رمز بريدي"readonly>
                    </div>
                    <div class="form-group row">
                        <label for="menu">موقع إلكتروني </label>
                        <input type="text" value="<?= $row['website']; ?>" class="form-control" id="website" name="website" placeholder="موقع إلكتروني"readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary " onclick="window.print()">طباعة</button>

                </div>
            </form>
        </div>
    </div>
</div>
</div>
