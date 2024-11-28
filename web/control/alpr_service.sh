if [ -z "$1" ]; then
    echo '{"error": "Nenhuma imagem fornecida."}'
    exit 1
fi

imagem="$1"

result=$(/usr/bin/alpr -c br -j -n 5 "$imagem")

echo "$result"