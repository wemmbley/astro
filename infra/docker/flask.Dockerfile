FROM python:3.12-slim

WORKDIR /app

COPY ./apps/flask/requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt

COPY ./apps/flask/ ./

EXPOSE 5000

CMD ["python", "server.py"]