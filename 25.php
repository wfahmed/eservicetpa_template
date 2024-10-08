<?php $index = 1; ?>
<?php foreach($orphans as $r) : ?>
    <tr>
        <td><?= $index; ?></td>
        <td><?= $r['full_name']; ?></td>
        <td><?= $r['age']; ?></td>
        <td><?= $r['mother_name']; ?></td>
        <td><?= $r['father_name']; ?></td>
        <td><?= $r['agent_name']; ?></td>
        <td><?= $r['agent_relation_type']; ?></td>
        <td>
            <!-- Dropdown Button -->
            <div class="dropdown">
                <button style="background-color:#722b75; color: white;" class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    الخيارات
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="badge  btn-style dropdown-item" style="background-color:#be36f1; color: white;" href="<?= site_url('member/detailmember/'.$r['id']); ?>">تفاصيل</a>
                    <a class="badge btn-style dropdown-item" style="background-color:#8e38de; color: white;" href="<?= site_url('member/edit_member/'.$r['father_id']); ?>">إدارة الأسرة</a>
                    <a class="badge   btn-style dropdown-item" style="background-color:#e767ec; color: white;" href="<?= site_url('cv/index/'.$r['id']); ?>" >السيرة الذاتية</a>

                </div>
            </div>



        </td>
    </tr>
    <?php $index++; ?>
<?php endforeach; ?>