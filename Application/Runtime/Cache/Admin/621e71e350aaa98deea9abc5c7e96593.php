<?php if (!defined('THINK_PATH')) exit(); if($day == 1): ?>星期1
    <?php elseif($day == 2): ?>
    星期2
        <?php elseif($day == 3): ?>
            星期3
            <?php elseif($day == 4): ?>
                星期4
                <?php elseif($day == 5): ?>
                    星期5
                    <?php elseif($day == 6): ?>
                        星期6
                        <?php else: ?>
                            星期7<?php endif; ?>