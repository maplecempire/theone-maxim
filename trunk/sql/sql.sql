select cp2.withdraw_id, cp2.dist_id, cp2.deduct, cp2.amount, cp2.bank_in_to
        , cp2.status_code, cp2.approve_reject_datetime, cp2.remarks
        , cp2.created_on
    FROM mlm_ecash_withdraw cp2
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = cp2.dist_id
where dist.tree_structure like '%|15|%' and cp2.created_on >= '2014-03-01 00:00:00'
 and cp2.created_on <= '2014-03-31 23:59:59'


select cp3.withdraw_id, cp3.dist_id, cp3.deduct, cp3.amount, cp3.bank_in_to
        , cp3.status_code, cp3.approve_reject_datetime, cp3.remarks
        , cp3.created_on
    FROM mlm_cp3_withdraw cp3
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = cp3.dist_id
where dist.tree_structure like '%|15|%' and cp3.created_on >= '2014-03-01 00:00:00'
 and cp3.created_on <= '2014-03-31 23:59:59'


 SELECT roi.dist_id, roi.mt4_user_name, dist.distributor_code
, roi.dividend_date, roi.roi_percentage, roi.dividend_amount, roi.status_code
, roi.created_on
	FROM mlm_roi_dividend roi
        LEFT JOIN mlm_distributor dist ON dist.distributor_id = roi.dist_id
WHERE roi.status_code = 'SUCCESS' and dist.tree_structure like '%|1807|%'





SELECT roi.dist_id, roi.mt4_user_name, roi.idx, roi.dividend_date
        , roi.package_id, roi.package_price, roi.roi_percentage, roi.mt4_balance
        , credit.mt4_credit
        , roi.dividend_amount, roi.remarks, roi.status_code, roi.created_by, roi.created_on, roi.first_dividend_date
        , dist.distributor_code, dist.full_name, dist.full_name, dist.status_code, dist.created_on, dist.remark
        , dist.loan_account
	FROM mlm_roi_dividend roi
        LEFT JOIN mlm_distributor dist ON roi.dist_id = dist.distributor_id
        LEFT JOIN
        (
            SELECT mt4_credit, mt4_user_name FROM mlm_daily_dist_mt4_credit group by dist_id order by traded_datetime desc
        ) credit ON credit.mt4_user_name = roi.mt4_user_name
WHERE idx = 18
and roi.dividend_date >= '2014-05-01 00:00:00'
and roi.dividend_date <= '2014-05-31 23:59:59'
order by dividend_date
limit 1000
GO
