<!DOCTYPE html>
<html>
<head>
    <style>
        :root {
            --primary: #176369;
            --text: #2c3e50;
            --background: #f5f7fa;
        }
        
        .katsinov-indicator {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 1rem;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .header.test {
            display: flex;
            align-items: stretch;
            border-bottom: 1px solid #edf2f7;
        }
        
        .title {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            color: var(--text);
            padding: 12px 16px;
            flex: 2;
            margin: 0;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-top-left-radius: 8px;
        }
        
        .value {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 16px;
            flex: 1;
            margin: 0;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .empty-cell {
            flex: 2;
            background-color: white;
            padding: 12px 16px;
            border-top-right-radius: 8px;
        }
        
        .description {
            padding: 12px 16px;
            margin: 0;
            font-size: 13px;
            color: var(--text);
            line-height: 1.4;
            background: var(--background);
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="katsinov-indicator">
        <div class="header.test">
            <h3 class="title">KATSINOV yang tercapai adalah =</h3>
            <h3 class="value">0</h3>
            <div class="empty-cell"></div>
        </div>
        <p class="description">KATSINOV yang dicapai adalah = KATSINOV tertinggi yang indikatornya terpenuhi</p>
    </div>

    <script src="{{ asset('indikator.js') }}"></script>
</body>
</html>