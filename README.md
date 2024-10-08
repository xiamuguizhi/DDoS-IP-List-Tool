![image](https://github.com/user-attachments/assets/971eaa8e-f064-49b7-a84e-9f3317a63789)

### 项目名称：DDoS IP段管理工具

### 项目简介：
该项目旨在提供一个简单的Web工具，用于管理DDoS IP段列表。用户可以通过网页表单提交新的IP段或IP地址，系统会自动检测是否已存在相同的IP段，并将不重复的IP段添加到列表文件中。此外，系统还支持将单个IP地址自动转换为对应的IP网段，避免用户手动计算和输入。

### 功能描述：

1. **提交IP段或IP地址**：
   - 用户可以通过文本框输入多个IP段（如 `192.168.0.0/24`）或单个IP地址（如 `192.168.0.1`），每行一个。
   - 输入内容可以是IP地址或CIDR格式的IP段。

2. **IP地址转换为CIDR网段**：
   - 当用户输入单个IP地址时，系统会自动将其转换为默认的`/24`网段。例如，`192.168.0.1` 会被转换为 `192.168.0.0/24`。
   - 这样可以避免用户手动转换，方便快捷。

3. **格式验证**：
   - 系统会对用户输入的IP地址或网段进行格式验证，确保输入内容符合标准的IPv4地址或CIDR格式。
   - 如果输入格式不正确，系统会提示用户错误，防止无效数据进入IP列表。

4. **查重功能**：
   - 系统会自动检测用户提交的IP段或IP地址是否已存在于当前的IP列表中。
   - 对于重复的IP段，系统会在页面上提示，避免重复添加。

5. **自动更新IP列表**：
   - 系统会将不重复的IP段或转换后的网段追加到IP列表文件（如`ddos-ip-list.txt`）中，确保列表的实时更新。

6. **结果反馈**：
   - 提交后，系统会在页面上反馈处理结果，展示成功添加的IP段以及重复的IP段。
   - 不同类型的反馈信息会以不同的颜色或样式显示，方便用户区分成功、错误或提示信息。

### 技术栈：
- **前端**：HTML + CSS，提供简单的响应式表单布局。
- **后端**：PHP，用于处理表单提交、格式验证、文件读写和结果反馈。

### 文件结构：
- `index.php`：核心文件，包含前端表单和后端处理逻辑。
- `ddos-ip-list.txt`：存储所有提交的IP段的文本文件。

### 使用说明：

1. 将项目克隆到本地服务器环境（如Laragon、XAMPP等）。
2. 访问`index.php`，使用表单提交IP段或IP地址。
3. 系统会自动检查重复项，并更新`ddos-ip-list.txt`文件。
4. 在页面上查看处理结果，包括成功添加的IP段和已存在的IP段。

### 示例输入：
```
192.168.0.1
192.168.1.0/24
10.0.0.5
172.16.0.0/16
```

- 输入`192.168.0.1` 会自动转换为`192.168.0.0/24`并进行查重。

### 示例输出：
- **成功添加的IP段**：
  - `192.168.1.0/24`
  - `10.0.0.0/24`
- **已存在的IP段**：
  - `192.168.0.0/24`（转换后的结果）
 
### 截图

![image](https://github.com/user-attachments/assets/1cd885d9-390d-4a1c-92be-96346f1190d1)


## 恶意攻击来源的 IP 网段

以下列出的 IP 网段已被标记为恶意攻击的来源。这些 IP 网段可能参与了非法访问、DDoS 攻击、入侵尝试等恶意活动。建议在防火墙规则中将这些 IP 网段封禁，以提高系统安全性。

请注意，这些 IP 网段的来源可能会动态变化，保持警惕，并定期更新您的安全策略。

```svg
# IP段清单
27.221.70.0/24
36.5.81.0/24
36.35.38.0/24
36.134.76.0/24
36.151.55.0/24
36.249.150.0/24
39.74.239.0/24
42.48.90.0/24
49.86.47.0/24
58.220.40.0/24
60.190.128.0/24
60.220.182.0/24
60.221.195.0/24
60.221.231.0/24
61.146.45.0/24
61.147.95.0/24
61.160.233.0/24
61.160.239.0/24
61.179.15.0/24
61.241.177.0/24
64.176.162.0/24
64.176.163.0/24
64.176.170.0/24
64.176.173.0/24
95.179.229.0/24
101.71.195.0/23
106.6.215.0/24
111.121.27.0/24
113.231.202.0/24
114.230.220.0/24
116.179.152.0/24
116.246.1.0/24
118.81.184.0/23
122.195.22.0/24
123.6.49.0/24
124.132.156.0/24
124.163.207.0/23
124.163.220.0/24
153.99.251.0/24
153.101.51.0/24
153.101.64.0/23
153.101.141.0/24
175.42.154.0/23
175.44.72.0/23
183.185.14.0/24
183.222.140.0/23
183.224.221.0/24
192.248.152.0/24
211.90.146.0/23
211.93.170.0/24
220.248.203.0/24
221.0.30.0/24
221.6.171.0/24
221.7.251.0/24
221.205.168.0/23
222.94.227.0/24
222.125.57.0/24
222.180.198.0/24
222.189.163.0/24
45.76.134.0/24
45.32.180.0/24
107.175.209.0/24
```
