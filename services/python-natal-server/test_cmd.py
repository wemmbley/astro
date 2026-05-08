from astro_core import calculate_chart
from chart_svg import render_chart
import datetime

chart = calculate_chart(
    datetime.datetime(2000, 12, 22, 16, 30),
    lat=49.49, lon=36.36
)
render_chart(chart, output_path="natal.svg")
