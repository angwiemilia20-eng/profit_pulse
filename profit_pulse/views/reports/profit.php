<div class="row g-3 justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Profit Summary</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td class="ps-4">Total Revenue (Sales)</td>
                            <td class="text-end pe-4 fw-semibold"><?= format_money($totalSales) ?></td>
                        </tr>
                        <tr>
                            <td class="ps-4">Cost of Goods Sold</td>
                            <td class="text-end pe-4 text-danger">− <?= format_money($cogs) ?></td>
                        </tr>
                        <tr class="table-light">
                            <td class="ps-4 fw-semibold">Gross Profit</td>
                            <td class="text-end pe-4 fw-bold text-success"><?= format_money($grossProfit) ?></td>
                        </tr>
                        <tr>
                            <td class="ps-4">Total Expenses</td>
                            <td class="text-end pe-4 text-danger">− <?= format_money($totalExpenses) ?></td>
                        </tr>
                        <tr class="table-primary">
                            <td class="ps-4 fw-bold fs-5">Net Profit</td>
                            <td class="text-end pe-4 fw-bold fs-5 <?= $netProfit >= 0 ? 'text-success' : 'text-danger' ?>">
                                <?= format_money($netProfit) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <p class="text-muted small mt-3 text-center">
            Gross Profit = Total Sales − COGS &nbsp;|&nbsp; Net Profit = Gross Profit − Expenses
        </p>
    </div>
</div>
