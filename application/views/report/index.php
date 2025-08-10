<div class="pageheader_custody_print">
    <div class="default_page">
        <?php
        if (!empty($orphan['dob'])) {
            $dobDate = new DateTime($orphan['dob']);
            $now = new DateTime();
            $age = $now->diff($dobDate)->y; // Calculate age in years
        } else {
            $age = 'غير متوفر'; // Default value if DOB is not available
        }
        ?>
        <?php
        function formatPhoneNumber($number)
        {
            // Check if the number has exactly 10 digits
            if (strlen($number) <= 10) {
                // Remove any non-numeric characters
                $number = preg_replace("/[^0-9]/", "", $number);

                // Pad with leading zeros to make it at least 10 digits
                $number = str_pad($number, 10, "0", STR_PAD_LEFT);

                // Format as per the desired pattern: 3 digits, 5 digits, 2 digits
                return substr($number, 0, 3) . " " . substr($number, 3, 5) . " " . substr($number, 8, 2);

            } else {
                // Return the original number if it doesn't have exactly 10 digits
                return $number;
            }
        }

        ?>
        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <?php if (!empty($orphan['image'])) { ?>
                    <td style="text-align: center; width: 120px;">
                        <img src="<?= base_url('assets/img/profile/') . $orphan['image']; ?>" alt="صورة اليتيم"
                             style="width: 100px; height: 100px; border-radius: 10px;">
                    </td>
                <?php } ?>
                <td colspan="<?= !empty($orphan['image']) ? 5 : 6 ?>"
                    class="org-title"><?= !empty($orphan['full_name']) ? '<h1>' . $orphan['full_name'] . '</h1>' : '<span style="color: black;"> الاسم/</span>' ?></td>
            </tr>

            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">رقم الهوية</td>
                <td class="bold-text"><?= !empty($orphan['identity']) ? $orphan['identity'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">تاريخ الميلاد</td>
                <td class="bold-text"><?= !empty($orphan['dob']) ? $orphan['dob'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الجنس</td>
                <td class="bold-text"><?= !empty($orphan['relation_type_id']) ? ($orphan['relation_type_id'] == 143 ? 'ذكر' : 'أنثى') : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>

            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">العمر</td>
                <td class="bold-text"><?= !empty($age) ? $age . ' سنة' : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;"></td>
                <td class="bold-text"></td>
                <td style="padding: 5px;background-color: #dfdfe1;"></td>
                <td class="bold-text"></td>
            </tr>

            <tr>
                <td colspan="6" style="background-color: #dae0e8"><h1>بيانات الوالد</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">رقم هوية</td>
                <td class="bold-text"><?= !empty($orphan['father_identity']) ? $orphan['father_identity'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الاسم</td>
                <td class="bold-text"><?= !empty($father['full_name']) ? $father['full_name'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الحالة</td>
                <td class="bold-text"><?= !empty($father['title']) ? $father['title'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">تاريخ ميلاد</td>
                <td class="bold-text"><?= !empty($father['dob']) ? $father['dob'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">طبيعة العمل</td>
                <td class="bold-text"><?= !empty($father['work_name']) ? $father['work_name'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الحالة الاجتماعية</td>
                <td class="bold-text"><?= !empty($father['maretal_name']) ? $father['maretal_name'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">تاريخ الوفاة</td>
                <td class="bold-text"><?= !empty($father['death_date']) ? $father['death_date'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">سبب الوفاة</td>
                <td colspan="3"
                    class="bold-text"><?= !empty($father['reason']) ? $father['reason'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">المواطنة</td>
                <td class="bold-text"><?= !empty($father['asylum_status_id']) ? ($father['asylum_status_id'] == 1 ? 'لاجئ' : 'مواطن') : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الدخل قبل</td>
                <td class="bold-text"><?= !empty($father['incom']) ? $father['incom'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الدخل بعد</td>
                <td class="bold-text"><?= !empty($father['after_death_incom']) ? $father['after_death_incom'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
        </table>


        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="6" style="background-color: #d8dce3"><h1>بيانات الوالدة</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">رقم هوية</td>
                <td class="bold-text"><?= !empty($orphan['mother_identity']) ? $orphan['mother_identity'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الاسم</td>
                <td class="bold-text"><?= !empty($mother['full_name']) ? $mother['full_name'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الحالة</td>
                <td class="bold-text"><?= !empty($mother['title']) ? $mother['title'] . 'ة' : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">تاريخ ميلاد</td>
                <td class="bold-text"><?= !empty($mother['dob']) ? $mother['dob'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">طبيعة العمل</td>
                <td class="bold-text"><?= !empty($mother['work_name']) ? $mother['work_name'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">الحالة الاجتماعية</td>
                <td class="bold-text"><?= !empty($mother['maretal_name']) ? $mother['maretal_name'] . 'ة' : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">تاريخ الوفاة</td>
                <td class="bold-text"><?= !empty($mother['death_date']) ? $mother['death_date'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;">سبب الوفاة</td>
                <td colspan="3"
                    class="bold-text"><?= !empty($mother['reason']) ? $mother['reason'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;">المواطنة</td>
                <td class="bold-text">
                    <?= !empty($mother['asylum_status_id']) ? ($mother['asylum_status_id'] == 1 ? 'لاجئة' : 'مواطن' . 'ة') : '<span style="color: white;">غير متوفر</span>'; ?>
                </td>
                <td style="padding: 5px;background-color: #dfdfe1;"> الدخل قبل</td>
                <td class="bold-text"><?= !empty($mother['incom']) ? $mother['incom'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
                <td style="padding: 5px;background-color: #dfdfe1;"> الدخل بعد</td>
                <td class="bold-text"><?= !empty($mother['after_death_incom']) ? $mother['after_death_incom'] : '<span style="color: white;">غير متوفر</span>'; ?></td>
            </tr>
        </table>


        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="6" style="background-color: #dae0e8"><h1>بيانات السكن</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px; background-color: #dfdfe1;">محافظة</td>
                <td class="bold-text"><?= $father['governorate_name'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">مدينة</td>
                <td class="bold-text"><?= $father['city_name'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">منطقة</td>
                <td class="bold-text"><?= $father['area_name'] ?? '<span style="color: white;">----------------</span>' ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">حي</td>
                <td class="bold-text"><?= $father['local_name'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">معلم</td>
                <td class="bold-text"><?= $father['land_name'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">مسجد</td>
                <td class="bold-text"><?= $father['mosque'] ?? '<span style="color: white;">----------------</span>' ?></td>
            </tr>
            <tr>
                <td style="padding: 5px; background-color: #dfdfe1;">عنوان المكان</td>
                <td colspan="5"
                    class="bold-text"><?= $father['detailed_original_housing_address'] ?? '<span style="color: white;">----------------</span>' ?></td>
            </tr>
            <tr>
                <td style="padding: 5px; background-color: #dfdfe1;">ملكية المنزل</td>
                <td class="bold-text"><?= $father['dwelling_title'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">حالة الضرر</td>
                <td class="bold-text"><?= $father['damage_title'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">التواجد</td>
                <td class="bold-text"><?= $father['valley_title'] ?? '<span style="color: white;">----------------</span>' ?></td>
            </tr>
            <tr>
                <td style="padding: 5px; background-color: #dfdfe1;">نازح</td>
                <td class="bold-text"><?= $father['residence_title'] ?? '<span style="color: white;">----------------</span>' ?></td>
                <td style="padding: 5px; background-color: #dfdfe1;">عنوان حالي</td>
                <td colspan="3"
                    class="bold-text"><?= $father['current_residence'] ?? '<span style="color: white;">----------------</span>' ?></td>
            </tr>
        </table>


        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #d8dce3">
                <td colspan="2"><h1>بيانات الاتصال</h1></td>
            </tr>
            <?php if (isset($contact)) { ?>
                <?php $i = 0;
                foreach ($contact as $per) {
                    $i++; ?>

                    <tr>
                        <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text"><?= $per['title'] ?></td>
                        <td class="bold-text" dir="ltr"><?= formatPhoneNumber($per['contact_value']) ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">جوال</td>
                <td class="bold-text" dir="ltr"></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">جوال</td>
                <td class="bold-text" dir="ltr"></td>
            </tr>
        </table>

        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #d8dce3">
                <td colspan="3"><h1>بيانات صحية</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">الإعاقة</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">الوضع الصحي</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">تفاصيل</td>
            </tr>
            <?php if (isset($health)) { ?>
                <?php $i = 0;
                foreach ($health as $per) {
                    $i++; ?>
                    <tr>
                        <td class="bold-text" dir="ltr"><?= $per['disability_type'] ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['health_status'] ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['health_details'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
        </table>

        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #d8dce3">
                <td colspan="3"><h1>بيانات العلمية</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">المرحلة</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">المستوى</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">التفاصيل</td>
            </tr>
            <?php if (isset($edu)) { ?>
                <?php $i = 0;
                foreach ($edu as $per) {
                    $i++; ?>
                    <tr>
                        <td class="bold-text" dir="ltr"><?= $per['edu_stage'] ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['edu_level'] ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['edu_details'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
        </table>

        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #d8dce3">
                <td colspan="2"><h1> الهوايات</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">#</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">الهواية</td>
            </tr>
            <?php if (isset($hob)) { ?>
                <?php $i = 0;
                foreach ($hob as $per) {
                    $i++;
                    $j = $i + 1; ?>
                    <tr>
                        <td class="bold-text" dir="ltr"><?= $j ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['hobby'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
        </table>

        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #d8dce3">
                <td colspan="3"><h1> الاحتياجات</h1></td>
            </tr>
            <tr>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">نوع الاحتياج</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">الاحتياج</td>
                <td style="padding: 5px;background-color: #dfdfe1;" class="bold-text">تفاصيل</td>
            </tr>
            <?php if (isset($hob)) { ?>
                <?php $i = 0;
                foreach ($hob as $per) {
                    $i++; ?>
                    <tr>
                        <td class="bold-text" dir="ltr"><?= $per['need_type'] ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['needu_sub_type'] ?></td>
                        <td class="bold-text" dir="ltr"><?= $per['need_details'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
            <tr>
                <td class="bold-text " style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
                <td class="bold-text" style="color: white"> فراغ</td>
            </tr>
        </table>
    </div>

    <style>
        .person-details-table {
            font-family: xbriyaz;
            margin-top: 8px;
            width: 100%;
        }

        .header-img {
            width: 20%;
            display: block;
            margin: auto;
        }

        .header-img-small {
            width: 15% !important;
            height: auto;
        }

        .person-details-table tr {
            line-height: 1.6;
        }

        .person-details-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
            width: auto;
            white-space: nowrap;
        }

        .org-title {
            text-align: center;
            font-weight: bold;
            color: darkred;
            font-size: 1.2em;
        }

        .bold-text {
            font-weight: bold;
        }
    </style>
