<?php
// 文件路径
$file_path = 'ddos-ip-list.txt';

// 初始化结果输出变量
$result_output = "";

// IP或网段格式验证函数
function is_valid_ip_or_cidr($input)
{
    // 验证是否是合法的CIDR格式或IP地址
    if (filter_var($input, FILTER_VALIDATE_IP)) {
        return 'ip';
    } elseif (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}\/[0-9]{1,2}$/', $input)) {
        return 'cidr';
    }
    return false;
}

// 将IP地址转换为相应的CIDR网段（默认/24）
function convert_ip_to_cidr($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return preg_replace('/\d{1,3}$/', '0', $ip) . '/24';
    }
    return false;
}

// 检查是否有表单提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 获取提交的IP段
    $new_ips = trim($_POST['ip_segments']);

    if (!empty($new_ips)) {
        // 将新提交的IP段按行分割成数组
        $new_ip_array = explode("\n", $new_ips);
        $new_ip_array = array_map('trim', $new_ip_array); // 去除每行的空格

        // 读取现有的IP段文件内容
        $existing_ips = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $duplicates = [];
        $unique_ips = [];

        foreach ($new_ip_array as $input) {
            $type = is_valid_ip_or_cidr($input);

            if ($type === 'ip') {
                // 如果是IP地址，转换为对应的CIDR网段
                $cidr = convert_ip_to_cidr($input);
                if ($cidr && in_array($cidr, $existing_ips)) {
                    $duplicates[] = $cidr;
                } elseif ($cidr) {
                    $unique_ips[] = $cidr;
                }
            } elseif ($type === 'cidr') {
                // 如果是CIDR网段，直接检查是否存在
                if (in_array($input, $existing_ips)) {
                    $duplicates[] = $input;
                } else {
                    $unique_ips[] = $input;
                }
            } else {
                // 无效的格式
                $result_output .= "<p class='error'>无效的IP或CIDR格式：$input</p>";
            }
        }

        // 如果有不重复的IP段，将其追加到文件
        if (!empty($unique_ips)) {
            file_put_contents($file_path, implode(PHP_EOL, $unique_ips) . PHP_EOL, FILE_APPEND);
        }

        // 生成结果输出
        $result_output .= "<div class='result'>";
        $result_output .= "<h2>结果:</h2>";

        if (!empty($duplicates)) {
            $result_output .= "<p class='error'>以下IP段已存在，未添加：</p>";
            $result_output .= "<ul class='error-list'>";
            foreach ($duplicates as $dup) {
                $result_output .= "<li>$dup</li>";
            }
            $result_output .= "</ul>";
        } else {
            $result_output .= "<p class='success'>没有重复的IP段。</p>";
        }

        if (!empty($unique_ips)) {
            $result_output .= "<p class='success'>以下IP段已成功添加：</p>";
            $result_output .= "<ul class='success-list'>";
            foreach ($unique_ips as $unique) {
                $result_output .= "<li>$unique</li>";
            }
            $result_output .= "</ul>";
        } else {
            $result_output .= "<p class='info'>没有新的IP段被添加。</p>";
        }
        $result_output .= "</div>";
    } else {
        $result_output .= "<p class='error'>请输入有效的IP段。</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP段查询与添加</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            /* 黑色背景 */
            color: #fff;
            /* 白色文字 */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #222;
            /* 深灰色容器背景 */
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            /* 白色阴影 */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
            /* 标题白色 */
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #444;
            /* 边框为较浅的灰色 */
            background-color: #111;
            /* 深灰色背景 */
            color: #fff;
            /* 白色文本 */
            margin-bottom: 15px;
            font-size: 14px;
            resize: vertical;
            /* 允许纵向调整大小 */
        }

        input[type="submit"] {
            width: 100%;
            background-color: #444;
            /* 按钮深灰色背景 */
            color: #fff;
            /* 按钮白色文字 */
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            /* 按钮颜色渐变 */
        }

        input[type="submit"]:hover {
            background-color: #555;
            /* 悬停时按钮背景变亮 */
        }

        .result {
            margin-top: 20px;
        }

        .error {
            color: #f44336;
            /* 错误信息红色 */
        }

        .success {
            color: #4caf50;
            /* 成功信息绿色 */
        }

        .info {
            color: #2196f3;
            /* 信息提示蓝色 */
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background-color: #333;
            /* 列表项深灰色背景 */
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #fff;
            /* 列表项左侧白色边框 */
        }

        .error-list li {
            border-left-color: #f44336;
            /* 错误列表项左侧红色边框 */
        }

        .success-list li {
            border-left-color: #4caf50;
            /* 成功列表项左侧绿色边框 */
        }

        /* 响应式设计 */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
                width: 90%;
            }

            textarea {
                font-size: 13px;
                padding: 8px;
            }

            input[type="submit"] {
                padding: 8px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>提交新的IP段</h1>
        <form method="POST" action="">
            <textarea name="ip_segments" rows="10" placeholder="每行一个IP段或IP地址，如 192.168.0.0/24 或 192.168.0.1"></textarea><br>
            <input type="submit" value="提交">
        </form>

        <!-- 显示结果 -->
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="result">
                <?php echo $result_output; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
