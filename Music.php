<?php

class Music
{
    public function getMusic($song)
    {
        $url = "http://tingapi.ting.baidu.com/v1/restserver/ting?format=json&calback=&from=webapp_music&method=baidu.ting.search.catalogSug&query={$song}";
        $data = json_decode(file_get_contents($url));
        $songid = $data->song[0]->songid;
        return $this->getSongByid($songid);
    }

    public function randomPlay()
    {
        $url ="http://tingapi.ting.baidu.com/v1/restserver/ting?format=json&calback=&from=webapp_music&method=baidu.ting.billboard.billList&type=1&size=20&offset=0";
        $data = json_decode(file_get_contents($url));
        $songid = $data->song_list[rand(0,20)]->song_id;
        return $this->getSongByid($songid);
    }

    public function getSongByid($songid)
    {
        $songurl = "http://tingapi.ting.baidu.com/v1/restserver/ting?format=json&calback=&from=webapp_music&method=baidu.ting.song.play&songid={$songid}";
        $data = json_decode( file_get_contents($songurl) );
        return array(
            "title" => $data->songinfo->title,
            "url" => $data->bitrate->file_link,
            "author" => $data->songinfo->author,
            "pic" => $data->songinfo->pic_small
        );
    }
}