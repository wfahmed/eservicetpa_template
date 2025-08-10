<div class="pageheader_custody_print">
<div class="default_page" style="margin-top: 13px;">

    <?php if(isset($orphan) ){   ?>
        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="6" class="org-title"><?=$orphan['full_name']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;"> رقم الهوية</td>
                <td  class="bold-text"><?= $orphan['identity ']; ?></td>
                <td style="padding: 5px;">تاريخ الميلاد</td>
                <td  class="bold-text"><?= $orphan['dob']; ?></td>
                <td style="padding: 5px;"> الجنس</td>
                <td class="bold-text">
                    <?= ($orphan['relation_type_id'] == 143) ? 'أنثى' : 'ذكر'; ?>
                </td>
            </tr>
            <tr>
                <td colspan="6">بيانات الوالد</td>
            </tr>
            <tr>
                <td style="padding: 5px;">رقم هوية </td>
                <td class="bold-text"><?= $orphan['father_identity']; ?></td>
                <td style="padding: 5px;">الاسم</td>
                <td class="bold-text"><?= $father['full_name']?></td>
                <td style="padding: 5px;">الحالة</td>
                <td class="bold-text"><?= $father['title']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">تاريخ ميلاد</td>
                <td class="bold-text"><?= $father['dob']; ?></td>
                <td style="padding: 5px;">طبيعة العمل</td>
                <td class="bold-text"><?= $father['work_name']?></td>
                <td style="padding: 5px;">الحالة الاجتماعية</td>
                <td class="bold-text"><?= $father['maretal_name']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">تاريخ الوفاة</td>
                <td class="bold-text"><?= $father['death_date']; ?></td>
                <td style="padding: 5px;">سبب الوفاة</td>
                <td colspan="3" class="bold-text"><?= $father['reason']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">المواطنة </td>
                <td class="bold-text">
                    <?= ($father['asylum_status_id'] == 1) ? 'لاجئ' : 'مواطن'; ?>
                </td>
                <td style="padding: 5px;"> الدخل قبل</td>
                <td class="bold-text"><?= $father['incom']?></td>
                <td style="padding: 5px;"> الدخل بعد</td>
                <td class="bold-text"><?= $father['after_death_incom']?></td>
            </tr>
            <tr>
                <td colspan="6">بيانات الوالدة</td>
            </tr>
            <tr>
                <td style="padding: 5px;">رقم هوية </td>
                <td class="bold-text"><?= $orphan['mother_identity']; ?></td>
                <td style="padding: 5px;">الاسم</td>
                <td class="bold-text"><?= $mother['full_name']?></td>
                <td style="padding: 5px;">الحالة</td>
                <td class="bold-text"><?= $mother['title']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">تاريخ ميلاد</td>
                <td class="bold-text"><?= $mother['dob']; ?></td>
                <td style="padding: 5px;">طبيعة العمل</td>
                <td class="bold-text"><?= $mother['work_name']?></td>
                <td style="padding: 5px;">الحالة الاجتماعية</td>
                <td class="bold-text"><?= $mother['maretal_name']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">تاريخ الوفاة</td>
                <td class="bold-text"><?= $mother['death_date']; ?></td>
                <td style="padding: 5px;">سبب الوفاة</td>
                <td colspan="3" class="bold-text"><?= $mother['reason']?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">المواطنة </td>
                <td class="bold-text">
                    <?= ($mother['asylum_status_id'] == 1) ? 'لاجئ' : 'مواطن'; ?>
                </td>
                <td style="padding: 5px;"> الدخل قبل</td>
                <td class="bold-text"><?= $mother['incom']?></td>
                <td style="padding: 5px;"> الدخل بعد</td>
                <td class="bold-text"><?= $mother['after_death_incom']?></td>
            </tr>
            <tr>
                <td colspan="6">بيانات السكن</td>
            </tr>
            <tr>
                <td style="padding: 5px;">محافظة</td>
                <td class="bold-text"><?= $father['governorate_name']; ?></td>
                <td style="padding: 5px;">مدينة</td>
                <td class="bold-text"><?= $father['city_name']; ?></td>
                <td style="padding: 5px;">منطقة</td>
                <td class="bold-text"><?= $father['area_name']; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">حي</td>
                <td class="bold-text"><?= $father['local_name']; ?></td>
                <td style="padding: 5px;">معلم</td>
                <td class="bold-text"><?= $father['land_name']; ?></td>
                <td style="padding: 5px;">مسجد</td>
                <td class="bold-text"><?= $father['mosque']; ?></td>
            </tr>
            <tr>
                <td style="padding: 5px;">عنوان المكان</td>
                <td colspan="5" class="bold-text"><?= $father['detailed_original_housing_address'] ?></td>
            </tr>
            <tr>
                <td   style="padding: 5px;">حالة المنزل </td>
                <td   class="bold-text"><?= $father['dwelling_title'] ?></td>
                <td   style="padding: 5px;">حالة الضرر </td>
                <td   class="bold-text"><?= $father['damage_title'] ?></td>
                <td   style="padding: 5px;"> التواجد </td>
                <td   class="bold-text"><?= $father['valley_title'] ?></td>
            </tr>
            <tr>
                <td   style="padding: 5px;">نازح </td>
                <td   class="bold-text"><?= $father['residence_title'] ?></td>
                <td   style="padding: 5px;">عنوان حالي </td>
                <td  colspan="3" class="bold-text"><?= $father['current_residence'] ?></td>
            </tr>
        </table>
    <?php } ?>
    <?php $i = 0; foreach ($contact as $per) { $i++; ?>
        <table class="person-details-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td   style="padding: 5px;">نوع الاتصال </td>
                <td   class="bold-text"><?= $per['title'] ?></td>
                <td   style="padding: 5px;"> الاتصال </td>
                <td  colspan="3" class="bold-text"><?= $per['contact_value'] ?></td>
            </tr>

        </table>
    <?php } ?>
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
