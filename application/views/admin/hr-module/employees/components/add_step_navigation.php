<style>
/*----- Steps Css -----*/
.step-wraper {
  padding: 25px;
  text-align: center;
  width: 100%;
  margin: 10px auto;
}

.step-wraper-list {
  border-top: 2px solid #dadadb;
  display: flex;
  list-style: none;
  padding: 0;
  justify-content: space-between;
  align-items: stretch;
  align-content: stretch;
}

.step-link {
  position: relative;
  margin-top: 12px;
  width: 100%;
}

.step-link a {
  font-weight: bold;
  text-decoration: none;
  color: #a7a7a7;
  text-transform: uppercase;
  font-size: 10px;
}

.step-link:first-child {
  margin-left: -70px;
}

.step-link:last-child {
  margin-right: -70px;
}

.step-link a::after {
    content: "";
    width: 15px;
    height: 15px;
    background: #fff;
    position: absolute;
    border-radius: 10px;
    top: -20px;
    left: 50%;
    transform: translatex(-50%);
    border: 2px solid #aeb7bf;
}

.step-link.prev a::before {
    border: 2px solid #fdce43;
    width: 100%;
    content: "";
    background: #fff;
    position: absolute;
    border-radius: 0px;
    top: -14px;
    left: 50%;
}

.step-link.prev a::after {
  border: 2px solid #fdce43;
}

.step-link.prev a::after{
  background: #fdce43;
}

.step-link.active a::after {
  border: 2px solid #fdce43;
}

.step-link.active a::after,
.step-link a:hover::after {
  background: #fdce43;
}
.twitter-bs-wizard .twitter-bs-wizard-pager-link li a {
    display: inline-block;
    padding: 0.47rem 0.75rem;
	color: #222;
    background-color: #e9e9e9 !important;
    border-color: #efefef;
    box-shadow: 2px 2px 3px #525252;
    border-radius: 0.25rem;
}
.twitter-bs-wizard .twitter-bs-wizard-pager-link li a:hover {
    box-shadow: none;
}
.twitter-bs-wizard .twitter-bs-wizard-pager-link li.next a {
	color: #fff;
    background-color: #1ea77a !important;
    border-color: #1ea77a;
    box-shadow: 2px 2px 3px #525252;
}
</style>
<ul class="step-wraper-list">
    <?php
    // Define step names
    $steps = [
        'Personal',
        'Address & Contacts',
        'Organization',
        'Insurance & DL',
        'Payments',
        'Documents',
        'Transactions',
        'Team Members'
    ];

    foreach ($steps as $index => $step_name):
        $step_number = $index + 1;
        $navClass = '';

        if ($step_number < $active_step) {
            $navClass = 'prev';
        } elseif ($step_number == $active_step) {
            $navClass = 'active';
        } elseif ($step_number > $active_step) {
            $navClass = 'next';
        }
        // Define step links
        $navLink = ($step_number == 1) ? base_url('admin/hr/employees/edit/step-' . $step_number . '/' . $nav_emp_id) :
            base_url('admin/hr/employees/add/step-' . $step_number . '/' . $nav_emp_id);
    ?>
        <li class="step-link <?php echo $navClass; ?>">
            <a href="<?php echo $navLink; ?>"><?php echo $step_name; ?></a>
        </li>
    <?php endforeach; ?>
</ul>