<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Transactions</title>
</head>

<body>
    <div class="container py-5">
        <div class="pb-3">
            <h1 class="pb-2">Transactions</h1>
            <div class="filters">
                <form action="" id="search_transaction">
                    <div class="row align-items-end">
                        <div class="col">
                            <label for="locations">Location</label>
                            <select name="location_id" id="locations" class="form-control">
                                <option value="">Select Location</option>
                                <?php foreach ($locations as $location) { ?>
                                    <option value="<?php echo $location['id']; ?>" <?php echo (isset($_GET['location_id']) && $location['id'] == $_GET['location_id']) ? 'selected' : ''; ?>>
                                        <?php echo $location['country'] . ', ' . $location['city']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="year">Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value="">Select Year</option>
                                <?php for ($i = 2022; $i <= intval(date('Y')); $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_GET['year']) && $i == $_GET['year']) ? 'selected' : ''; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="month">Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value="">Select Month</option>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_GET['month']) && $i == $_GET['month']) ? 'selected' : ''; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="month">Day</label>
                            <select name="day" id="day" class="form-control">
                                <option value="">Select Day</option>
                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo (isset($_GET['day']) && $i == $_GET['day']) ? 'selected' : ''; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <input type="hidden" name="page" value="<?php echo $page; ?>" />
                        <input type="hidden" name="search" value="1" />
                        <div class="col">
                            <input type="submit" class="btn btn-primary" value="search" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr class="table-dark">
                    <th>User</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction) { ?>
                    <tr>
                        <td><?= $transaction['name'] ?? ''; ?></td>
                        <td><?= $transaction['email'] ?? ''; ?></td>
                        <td><?= $transaction['country'] ?? ''; ?></td>
                        <td><?= $transaction['state'] ?? ''; ?></td>
                        <td><?= $transaction['city'] ?? ''; ?></td>
                        <td><?= $transaction['amount'] ?? ''; ?></td>
                        <td><?= $transaction['date'] ?? ''; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php $max = 10;
                    $loop = 1;
                    $location_id = $_GET['location_id'] ?? '';
                    $year = $_GET['year'] ?? '';
                    $month = $_GET['month'] ?? '';
                    $day = $_GET['day'] ?? '';
                    $search = $_GET['search'] ?? '';
                    $extraParams = !empty($location_id) ? '&location_id='.$location_id : '';
                    $extraParams .= !empty($extraParams) ? (!empty($year) ? '&year='.$year : '') : '';
                    $extraParams .= !empty($extraParams) ? (!empty($month) ? '&month='.$month : '') : '';
                    $extraParams .= !empty($extraParams) ? (!empty($day) ? '&day='.$day : '') : '';
                    $extraParams .= !empty($extraParams) ? (!empty($search) ? '&search='.$search : '') : '';
                    for ($i = $page; $i < ($max + $page + 1); $i++) { ?>
                        <?php if ($loop++ === 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="transactions?page=<?php echo ($i === 1) ? $i : $i - 1; echo $extraParams; ?>">Previous</a>
                            </li>
                        <?php } ?>
                        <li class="page-item<?php echo ($i === $page) ? ' active' : ''; ?>">
                            <a class="page-link" href="transactions?page=<?php echo $i . $extraParams; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php if ($i === ($max + $page)) { ?>
                            <li class="page-item">
                                <a class="page-link" href="transactions?page=<?php echo ($i + 1) . $extraParams; ?>">Next</a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>