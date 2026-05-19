const formatDate = (iso: string) =>
    new Date(iso).toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    });

const isFresh = (dateStr: string): boolean =>
    (Date.now() - new Date(dateStr).getTime()) / (1000 * 60 * 60 * 24) <= 3;
