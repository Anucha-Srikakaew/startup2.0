DELETE t1
FROM
    startup_item t1
    INNER JOIN startup_item t2
WHERE
    t1.ID > t2.ID
    AND t1.`COUNTRY` = t2.`COUNTRY`
    AND t1.`FACTORY` = t2.`FACTORY`
    AND t1.`BIZ` = t2.`BIZ`
    AND t1.`LINE` = t2.`LINE`
    AND t1.`TYPE` = t2.`TYPE`
    AND t1.`MODEL` = t2.`MODEL`
    AND t1.`PROCESS` = t2.`PROCESS`
    AND t1.`ITEM` = t2.`ITEM`
    AND t1.`SPEC_DES` = t2.`SPEC_DES`
    AND t1.`SHIFT_DATE` = t2.`SHIFT_DATE`
    AND t1.`SHIFT` = t2.`SHIFT`
    AND t1.`PERIOD` = t2.`PERIOD`