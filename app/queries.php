<?php
/**
 * Shared listing queries for articles and advertisements.
 * Filters: q (search text), city (slug), category (slug), user_id.
 */

function post_select(string $table): string
{
    return "SELECT p.*, u.name AS author, u.username, u.university,
                   c.name AS city, c.slug AS city_slug,
                   k.name AS category, k.slug AS category_slug
            FROM `$table` p
            JOIN users u ON u.id = p.user_id
            JOIN cities c ON c.id = p.city_id
            JOIN categories k ON k.id = p.category_id";
}

function post_where(string $table, array $f): array
{
    $where = [];
    $params = [];
    $text = $table === 'articles' ? 'p.body' : 'p.description';

    if (!empty($f['q'])) {
        foreach (array_slice(preg_split('/\s+/u', $f['q']), 0, 5) as $word) {
            $like = '%' . addcslashes($word, '%_\\') . '%';
            $where[] = "(p.title LIKE ? OR $text LIKE ? OR c.name LIKE ? OR k.name LIKE ?)";
            array_push($params, $like, $like, $like, $like);
        }
    }
    if (!empty($f['city'])) {
        $where[] = 'c.slug = ?';
        $params[] = $f['city'];
    }
    if (!empty($f['category'])) {
        $where[] = 'k.slug = ?';
        $params[] = $f['category'];
    }
    if (!empty($f['user_id'])) {
        $where[] = 'p.user_id = ?';
        $params[] = $f['user_id'];
    }
    return [$where ? ' WHERE ' . implode(' AND ', $where) : '', $params];
}

function find_posts(string $table, array $f = [], int $limit = 12, int $offset = 0): array
{
    [$where, $params] = post_where($table, $f);
    $sql = post_select($table) . $where . ' ORDER BY p.created_at DESC, p.id DESC LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
    return q($sql, $params)->fetchAll();
}

function count_posts(string $table, array $f = []): int
{
    [$where, $params] = post_where($table, $f);
    $sql = "SELECT COUNT(*) FROM `$table` p
            JOIN cities c ON c.id = p.city_id
            JOIN categories k ON k.id = p.category_id" . $where;
    return (int) q($sql, $params)->fetchColumn();
}

function find_post(string $table, string $slug): ?array
{
    return q(post_select($table) . ' WHERE p.slug = ?', [$slug])->fetch() ?: null;
}

/** Listing page data: filters from the URL, rows, and paging numbers. */
function listing(string $table, int $perPage = 12): array
{
    $filters = ['q' => query('q'), 'city' => query('city'), 'category' => query('category')];
    $total = count_posts($table, $filters);
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min($pages, max(1, (int) query('page')));
    return [
        'filters' => $filters,
        'rows'    => find_posts($table, $filters, $perPage, ($page - 1) * $perPage),
        'total'   => $total,
        'page'    => $page,
        'pages'   => $pages,
    ];
}
